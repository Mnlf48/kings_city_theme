<?php
if (!defined('ABSPATH')) exit;
/**
 * Email Campaigns Scheduler
 *
 * Registers the `kc_campaign` Custom Post Type.
 * Admins create a campaign (subject, body, scheduled date/time, target audience).
 * A 15-minute cron job picks up "Scheduled" campaigns whose date has arrived
 * and sends them in batches of 50, updating the offset so no email is sent twice.
 *
 * @package KingsCity
 */

// ---------------------------------------------------------------------------
// 1. Register CPT
// ---------------------------------------------------------------------------
add_action('init', 'kc_register_campaign_cpt');
function kc_register_campaign_cpt() {
    $labels = array(
        'name'               => 'Email Campaigns',
        'singular_name'      => 'Email Campaign',
        'menu_name'          => 'Email Campaigns',
        'name_admin_bar'     => 'Email Campaign',
        'add_new'            => 'New Campaign',
        'add_new_item'       => 'Create New Campaign',
        'edit_item'          => 'Edit Campaign',
        'all_items'          => 'All Campaigns',
        'search_items'       => 'Search Campaigns',
        'not_found'          => 'No campaigns found.',
    );

    register_post_type('kc_campaign', array(
        'labels'          => $labels,
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => 'edit.php?post_type=kc_welcome_packet', // Nest under Newsletters menu
        'query_var'       => false,
        'rewrite'         => false,
        'capability_type' => 'post',
        'has_archive'     => false,
        'hierarchical'    => false,
        'menu_position'   => null,
        'supports'        => array('title'), // Title = campaign name for internal reference
    ));
}

// ---------------------------------------------------------------------------
// 2. Meta Boxes
// ---------------------------------------------------------------------------
add_action('add_meta_boxes', 'kc_campaign_meta_boxes');
function kc_campaign_meta_boxes() {
    add_meta_box(
        'kc_campaign_details',
        'Campaign Details',
        'kc_render_campaign_meta_box',
        'kc_campaign',
        'normal',
        'high'
    );
    add_meta_box(
        'kc_campaign_status_box',
        'Campaign Status & Progress',
        'kc_render_campaign_status_box',
        'kc_campaign',
        'side',
        'high'
    );
}

function kc_render_campaign_meta_box($post) {
    wp_nonce_field('kc_campaign_save_meta', 'kc_campaign_nonce');

    $subject   = get_post_meta($post->ID, 'kc_camp_subject',   true) ?: '';
    $heading   = get_post_meta($post->ID, 'kc_camp_heading',   true) ?: '';
    $body      = get_post_meta($post->ID, 'kc_camp_body',      true) ?: '';
    $banner    = get_post_meta($post->ID, 'kc_camp_banner',    true) ?: '';
    $btn_text  = get_post_meta($post->ID, 'kc_camp_btn_text',  true) ?: '';
    $btn_url   = get_post_meta($post->ID, 'kc_camp_btn_url',   true) ?: '';
    $scheduled = get_post_meta($post->ID, 'kc_camp_scheduled_at', true) ?: '';
    $audience  = get_post_meta($post->ID, 'kc_camp_audience',  true) ?: 'active';
    ?>
    <style>
        .kc-camp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .kc-camp-field { margin-bottom: 15px; }
        .kc-camp-field label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e293b; }
        .kc-camp-field input[type="text"],
        .kc-camp-field input[type="datetime-local"],
        .kc-camp-field input[type="url"],
        .kc-camp-field select,
        .kc-camp-field textarea { width: 100%; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 14px; }
        .kc-camp-field textarea { min-height: 120px; font-family: inherit; }
        .kc-camp-notice { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 12px 15px; margin-bottom: 15px; font-size: 13px; color: #1e40af; }
        .kc-camp-notice strong { display: block; margin-bottom: 4px; }
        .kc-token-list { margin: 5px 0 0; padding: 0; list-style: none; }
        .kc-token-list li { display: inline-block; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 3px; padding: 2px 8px; font-family: monospace; font-size: 12px; margin: 2px 3px 2px 0; }
    </style>

    <div class="kc-camp-notice">
        <strong>ℹ️ Available body tokens:</strong>
        <ul class="kc-token-list">
            <li>{first_name}</li>
            <li>{email}</li>
            <li>{promo_code}</li>
            <li>{site_url}</li>
            <li>{unsubscribe_url}</li>
        </ul>
    </div>

    <div class="kc-camp-field">
        <label>Email Subject Line *</label>
        <input type="text" name="kc_camp_subject" value="<?php echo esc_attr($subject); ?>" placeholder="e.g. Exclusive Summer Offer for You 🌞" />
    </div>

    <div class="kc-camp-grid">
        <div class="kc-camp-field">
            <label>Scheduled Date & Time *</label>
            <input type="datetime-local" name="kc_camp_scheduled_at" value="<?php echo esc_attr($scheduled); ?>" />
            <p style="font-size:11px;color:#64748b;margin:4px 0 0;">Server time. The cron runs every 15 minutes.</p>
        </div>
        <div class="kc-camp-field">
            <label>Target Audience</label>
            <select name="kc_camp_audience">
                <option value="active"   <?php selected($audience, 'active'); ?>>Active Subscribers Only</option>
                <option value="all"      <?php selected($audience, 'all');    ?>>All Subscribers (including Pending)</option>
            </select>
        </div>
    </div>

    <div class="kc-camp-field">
        <label>Attach Promo Code (Optional)</label>
        <select name="kc_camp_promo_id">
            <option value="">-- None --</option>
            <?php
            $promos = get_posts(array('post_type' => 'kc_promo', 'posts_per_page' => -1, 'post_status' => 'publish'));
            $linked_promo = get_post_meta($post->ID, 'kc_camp_promo_id', true);
            foreach ($promos as $p) {
                echo '<option value="' . esc_attr($p->ID) . '" ' . selected($linked_promo, $p->ID, false) . '>' . esc_html($p->post_title) . '</option>';
            }
            ?>
        </select>
        <p style="font-size:11px;color:#64748b;margin:4px 0 0;">Select a code to attach. You must use the <code>{promo_code}</code> token in your message below to display it to the user.</p>
    </div>

    <div class="kc-camp-field">
        <label>Email Heading (large hero text)</label>
        <input type="text" name="kc_camp_heading" value="<?php echo esc_attr($heading); ?>" placeholder="e.g. A Special Offer Just for You" />
    </div>

    <div class="kc-camp-field">
        <label>Banner Subtext (appears below heading)</label>
        <input type="text" name="kc_camp_banner" value="<?php echo esc_attr($banner); ?>" placeholder="e.g. Save 20% on any space this month." />
    </div>

    <div class="kc-camp-field">
        <label>Body / Main Message</label>
        <textarea name="kc_camp_body" placeholder="Full email body text. Use {first_name} to personalise..."><?php echo esc_textarea($body); ?></textarea>
    </div>

    <div class="kc-camp-grid">
        <div class="kc-camp-field">
            <label>Button Label</label>
            <input type="text" name="kc_camp_btn_text" value="<?php echo esc_attr($btn_text); ?>" placeholder="e.g. Book Now" />
        </div>
        <div class="kc-camp-field">
            <label>Button URL</label>
            <input type="url" name="kc_camp_btn_url" value="<?php echo esc_attr($btn_url); ?>" placeholder="https://..." />
        </div>
    </div>
    <?php
}

function kc_render_campaign_status_box($post) {
    $status   = get_post_meta($post->ID, 'kc_camp_status',      true) ?: 'draft';
    $sent     = (int) get_post_meta($post->ID, 'kc_camp_sent_count',  true);
    $failed   = (int) get_post_meta($post->ID, 'kc_camp_fail_count',  true);
    $offset   = (int) get_post_meta($post->ID, 'kc_camp_offset',      true);
    $total    = (int) get_post_meta($post->ID, 'kc_camp_total_count', true);

    $badge_colors = array(
        'draft'     => '#64748b',
        'scheduled' => '#0ea5e9',
        'sending'   => '#f59e0b',
        'sent'      => '#22c55e',
        'failed'    => '#ef4444',
    );
    $color = $badge_colors[$status] ?? '#64748b';
    ?>
    <style>
        .kc-camp-status-badge {
            display: inline-block; padding: 4px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .kc-camp-stat { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .kc-camp-stat:last-child { border-bottom: none; }
        .kc-camp-stat-label { color: #64748b; font-weight: 600; }
        .kc-camp-stat-val { color: #0f172a; font-weight: 700; }
    </style>

    <p><span class="kc-camp-status-badge" style="background: <?php echo esc_attr($color); ?>;"><?php echo esc_html(ucfirst($status)); ?></span></p>

    <div class="kc-camp-stat"><span class="kc-camp-stat-label">Status</span>
        <select name="kc_camp_status" style="font-size:12px; padding:2px 4px;">
            <option value="draft"     <?php selected($status, 'draft');     ?>>Draft</option>
            <option value="scheduled" <?php selected($status, 'scheduled'); ?>>Scheduled</option>
            <option value="sending"   <?php selected($status, 'sending');   ?>>Sending…</option>
            <option value="sent"      <?php selected($status, 'sent');      ?>>Sent ✅</option>
            <option value="failed"    <?php selected($status, 'failed');    ?>>Failed ❌</option>
        </select>
    </div>

    <?php if ($total > 0) : ?>
    <div class="kc-camp-stat"><span class="kc-camp-stat-label">Total Audience</span><span class="kc-camp-stat-val"><?php echo number_format($total); ?></span></div>
    <div class="kc-camp-stat"><span class="kc-camp-stat-label">Emails Sent</span><span class="kc-camp-stat-val" style="color:#22c55e;"><?php echo number_format($sent); ?></span></div>
    <div class="kc-camp-stat"><span class="kc-camp-stat-label">Failed</span><span class="kc-camp-stat-val" style="color:#ef4444;"><?php echo number_format($failed); ?></span></div>
    <div class="kc-camp-stat"><span class="kc-camp-stat-label">Remaining</span><span class="kc-camp-stat-val"><?php echo number_format(max(0, $total - $offset)); ?></span></div>
    <?php else : ?>
    <p style="color:#94a3b8; font-size:12px; margin-top:8px;">Stats will appear once sending starts.</p>
    <?php endif; ?>

    <?php if (in_array($status, ['scheduled', 'sending'])) : ?>
        <hr style="margin: 15px 0; border: 0; border-top: 1px solid #e2e8f0;">
        <button type="button" id="kc-force-send-btn" class="button button-primary" style="width:100%; text-align:center;">Force Send Now</button>
        <p style="font-size:11px; color:#64748b; margin-top:8px; line-height:1.4;">Bypass the background cron schedule and send the next batch immediately.</p>
        
        <script>
        jQuery(document).ready(function($) {
            $('#kc-force-send-btn').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                btn.prop('disabled', true).text('Sending...');
                $.post(ajaxurl, {
                    action: 'kc_force_send_campaign',
                    nonce: '<?php echo esc_js(wp_create_nonce("kc_force_send_campaign")); ?>'
                }, function(res) {
                    if (res.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (res.data || 'Unknown error'));
                        btn.prop('disabled', false).text('Force Send Now');
                    }
                });
            });
        });
        </script>
    <?php endif; ?>
    <?php
}

// ---------------------------------------------------------------------------
// 3. Save Meta
// ---------------------------------------------------------------------------
add_action('save_post_kc_campaign', 'kc_campaign_save_meta');
function kc_campaign_save_meta($post_id) {
    if (!isset($_POST['kc_campaign_nonce']) || !wp_verify_nonce($_POST['kc_campaign_nonce'], 'kc_campaign_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $text_fields = [
        'kc_camp_subject', 'kc_camp_heading', 'kc_camp_banner',
        'kc_camp_btn_text', 'kc_camp_audience', 'kc_camp_status',
        'kc_camp_scheduled_at', 'kc_camp_promo_id',
    ];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
    if (isset($_POST['kc_camp_body'])) {
        update_post_meta($post_id, 'kc_camp_body', sanitize_textarea_field($_POST['kc_camp_body']));
    }
    if (isset($_POST['kc_camp_btn_url'])) {
        update_post_meta($post_id, 'kc_camp_btn_url', esc_url_raw($_POST['kc_camp_btn_url']));
    }
}

// ---------------------------------------------------------------------------
// 4. Admin Columns
// ---------------------------------------------------------------------------
add_filter('manage_kc_campaign_posts_columns', 'kc_campaign_set_columns');
function kc_campaign_set_columns($cols) {
    return array(
        'cb'        => $cols['cb'],
        'title'     => 'Campaign Name',
        'status'    => 'Status',
        'scheduled' => 'Scheduled At',
        'audience'  => 'Audience',
        'progress'  => 'Progress',
        'date'      => 'Created',
    );
}

add_action('manage_kc_campaign_posts_custom_column', 'kc_campaign_custom_column', 10, 2);
function kc_campaign_custom_column($col, $id) {
    switch ($col) {
        case 'status':
            $status = get_post_meta($id, 'kc_camp_status', true) ?: 'draft';
            $colors = ['draft'=>'#94a3b8','scheduled'=>'#0ea5e9','sending'=>'#f59e0b','sent'=>'#22c55e','failed'=>'#ef4444'];
            $c = $colors[$status] ?? '#94a3b8';
            echo '<span style="background:' . esc_attr($c) . ';color:#fff;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:700;text-transform:uppercase;">' . esc_html(ucfirst($status)) . '</span>';
            break;
        case 'scheduled':
            $dt = get_post_meta($id, 'kc_camp_scheduled_at', true);
            echo $dt ? esc_html(date_i18n('M j, Y g:i A', strtotime($dt))) : '<em style="color:#94a3b8">—</em>';
            break;
        case 'audience':
            $a = get_post_meta($id, 'kc_camp_audience', true) ?: 'active';
            echo esc_html($a === 'all' ? 'All Subscribers' : 'Active Only');
            break;
        case 'progress':
            $total = (int) get_post_meta($id, 'kc_camp_total_count', true);
            $sent  = (int) get_post_meta($id, 'kc_camp_sent_count',  true);
            if ($total > 0) {
                $pct = round(($sent / $total) * 100);
                echo esc_html($sent) . ' / ' . esc_html(number_format($total)) . ' <span style="color:#64748b;font-size:11px;">(' . $pct . '%)</span>';
            } else {
                echo '<em style="color:#94a3b8">Not started</em>';
            }
            break;
    }
}

// Make columns sortable by scheduled date
add_filter('manage_edit-kc_campaign_sortable_columns', function($cols) {
    $cols['scheduled'] = 'scheduled';
    return $cols;
});

// ---------------------------------------------------------------------------
// 5. 15-Minute Cron: Process Campaigns in Batches of 50
// ---------------------------------------------------------------------------
add_filter('cron_schedules', 'kc_add_15min_schedule');
function kc_add_15min_schedule($schedules) {
    if (!isset($schedules['kc_every_15min'])) {
        $schedules['kc_every_15min'] = array(
            'interval' => 900, // 15 minutes
            'display'  => __('Every 15 Minutes'),
        );
    }
    return $schedules;
}

// Schedule event on every page load if not already set
if (!wp_next_scheduled('kc_process_campaigns_cron')) {
    wp_schedule_event(time(), 'kc_every_15min', 'kc_process_campaigns_cron');
}

add_action('kc_process_campaigns_cron', 'kc_run_campaign_batch');
function kc_run_campaign_batch() {
    global $wpdb;
    $mailing_table = $wpdb->prefix . 'kc_mailing_list';
    $now_str = current_time('Y-m-d H:i:s');

    // Find campaigns that are 'scheduled' and whose scheduled_at time has arrived
    $campaigns = get_posts(array(
        'post_type'      => 'kc_campaign',
        'posts_per_page' => 5, // Process up to 5 campaigns per cron run
        'post_status'    => 'publish',
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'kc_camp_status',
                'value'   => array('scheduled', 'sending'),
                'compare' => 'IN',
            ),
            array(
                'key'     => 'kc_camp_scheduled_at',
                'value'   => $now_str,
                'compare' => '<=',
                'type'    => 'DATETIME',
            ),
        ),
    ));

    if (empty($campaigns)) return;

    foreach ($campaigns as $campaign) {
        $post_id   = $campaign->ID;
        $status    = get_post_meta($post_id, 'kc_camp_status',     true);
        $audience  = get_post_meta($post_id, 'kc_camp_audience',   true) ?: 'active';
        $offset    = (int) get_post_meta($post_id, 'kc_camp_offset',  true);
        $sent      = (int) get_post_meta($post_id, 'kc_camp_sent_count', true);
        $failed    = (int) get_post_meta($post_id, 'kc_camp_fail_count', true);
        $batch     = 50;

        // Get email template fields
        $subject   = get_post_meta($post_id, 'kc_camp_subject',    true) ?: 'A message from The Kings City Club';
        $heading   = get_post_meta($post_id, 'kc_camp_heading',    true) ?: '';
        $body_raw  = get_post_meta($post_id, 'kc_camp_body',       true) ?: '';
        $banner    = get_post_meta($post_id, 'kc_camp_banner',     true) ?: '';
        $btn_text  = get_post_meta($post_id, 'kc_camp_btn_text',   true) ?: 'Visit Us';
        $btn_url   = get_post_meta($post_id, 'kc_camp_btn_url',    true) ?: home_url('/');
        
        $promo_id  = get_post_meta($post_id, 'kc_camp_promo_id',   true);
        $promo_code = $promo_id ? get_the_title($promo_id) : '';

        // On the very first batch: calculate total and mark as sending
        if ($status === 'scheduled') {
            $total = (int) $wpdb->get_var(
                $audience === 'all'
                    ? "SELECT COUNT(*) FROM {$mailing_table}"
                    : "SELECT COUNT(*) FROM {$mailing_table} WHERE status = 'active'"
            );
            update_post_meta($post_id, 'kc_camp_total_count', $total);
            update_post_meta($post_id, 'kc_camp_status',      'sending');
            update_post_meta($post_id, 'kc_camp_offset',      0);
            $offset = 0;
        }

        // Fetch next batch of subscribers
        $where = $audience === 'all' ? '' : "WHERE status = 'active'";
        $rows = $wpdb->get_results(
            $wpdb->prepare("SELECT email FROM {$mailing_table} {$where} ORDER BY id ASC LIMIT %d OFFSET %d", $batch, $offset),
            ARRAY_A
        );

        if (empty($rows)) {
            // We've reached the end — mark as sent
            update_post_meta($post_id, 'kc_camp_status', 'sent');
            continue;
        }

        $headers = array('Content-Type: text/html; charset=UTF-8');

        foreach ($rows as $row) {
            $email = $row['email'];

            // Personalise tokens across all fields
            $search  = ['{first_name}', '{email}', '{promo_code}', '{site_url}', '{unsubscribe_url}'];
            $replace = [
                ucfirst(strstr($email, '@', true)), // best-effort first name from email
                $email,
                $promo_code,
                home_url('/'),
                home_url('/?kc_unsubscribe=' . urlencode($email)),
            ];

            $body = str_replace($search, $replace, $body_raw);
            $parsed_subject = str_replace($search, $replace, $subject);
            $parsed_heading = str_replace($search, $replace, $heading);
            $parsed_banner  = str_replace($search, $replace, $banner);
            $parsed_btn_url = str_replace($search, $replace, $btn_url);
            $parsed_btn_text = str_replace($search, $replace, $btn_text);

            // Build HTML using the branded template
            $email_heading  = $parsed_heading;
            $email_body     = wpautop($body);
            $email_banner   = $parsed_banner;
            $email_btn_text = $parsed_btn_text;
            $email_btn_url  = $parsed_btn_url;

            ob_start();
            include get_template_directory() . '/emails/email-newsletter.php';
            $html = ob_get_clean();

            // Add List-Unsubscribe header for better deliverability
            $unsub_url = home_url('/?kc_unsubscribe=' . urlencode($email));
            $camp_headers = $headers;
            $camp_headers[] = 'List-Unsubscribe: <' . $unsub_url . '>';

            $result = wp_mail(trim($email), $parsed_subject, $html, $camp_headers);
            if ($result) {
                $sent++;
            } else {
                $failed++;
            }
        }

        update_post_meta($post_id, 'kc_camp_offset',     $offset + $batch);
        update_post_meta($post_id, 'kc_camp_sent_count', $sent);
        update_post_meta($post_id, 'kc_camp_fail_count', $failed);

        // If fewer rows than batch size, we're done
        if (count($rows) < $batch) {
            update_post_meta($post_id, 'kc_camp_status', 'sent');
        }
    }
}

// ---------------------------------------------------------------------------
// 6. Manual Force Send AJAX
// ---------------------------------------------------------------------------
add_action('wp_ajax_kc_force_send_campaign', 'kc_force_send_campaign_ajax');
function kc_force_send_campaign_ajax() {
    check_ajax_referer('kc_force_send_campaign', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error('Unauthorized');
    
    // Call the cron function manually in this synchronous admin request
    kc_run_campaign_batch();
    
    wp_send_json_success();
}
