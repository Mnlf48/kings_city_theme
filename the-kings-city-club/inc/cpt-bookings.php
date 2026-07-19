<?php
if (!defined('ABSPATH')) exit;

function kc_register_cpt_bookings() {
    $labels = array(
        'name'               => 'Bookings',
        'singular_name'      => 'Booking',
        'menu_name'          => 'Bookings',
        'name_admin_bar'     => 'Booking',
        'add_new'            => 'Add New Booking',
        'add_new_item'       => 'Add New Booking',
        'new_item'           => 'New Booking',
        'edit_item'          => 'Edit Booking',
        'view_item'          => 'View Booking',
        'all_items'          => 'All Bookings',
        'search_items'       => 'Search Bookings',
        'not_found'          => 'No bookings found.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 27,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title'),
        'capability_type'    => array('kc_booking', 'kc_bookings'),
        'capabilities'       => array(
            'create_posts' => 'do_not_allow',
        ),
        'map_meta_cap'       => true,
    );

    register_post_type('kc_booking', $args);
}
add_action('init', 'kc_register_cpt_bookings');

// --- Custom Columns ---

function kc_set_custom_edit_kc_booking_columns($columns) {
    unset($columns['date']);
    $columns['client_info'] = 'Client Name';
    $columns['space_info']  = 'Space & Date';
    $columns['invoice']     = 'Invoice';
    $columns['status']      = 'Status';
    $columns['membership']  = 'Membership';
    $columns['date']        = 'Submitted';
    return $columns;
}
add_filter('manage_kc_booking_posts_columns', 'kc_set_custom_edit_kc_booking_columns');

function kc_custom_kc_booking_column($column, $post_id) {
    switch ($column) {
        case 'client_info':
            $fname = get_post_meta($post_id, 'kc_first_name', true);
            $lname = get_post_meta($post_id, 'kc_last_name', true);
            $email = get_post_meta($post_id, 'kc_email', true);
            $phone = get_post_meta($post_id, 'kc_phone', true);
            $edit_link = get_edit_post_link($post_id);
            echo "<strong><a href='" . esc_url($edit_link) . "' class='row-title'>" . esc_html("$fname $lname") . "</a></strong><br>";
            echo "<a href='mailto:" . esc_attr($email) . "'>" . esc_html($email) . "</a><br>";
            echo esc_html($phone);
            break;
        case 'space_info':
            $space = get_post_meta($post_id, 'kc_space_type', true);
            $duration = get_post_meta($post_id, 'kc_duration', true);
            $date = get_post_meta($post_id, 'kc_start_date', true);
            $price = get_post_meta($post_id, 'kc_price', true);
            echo "<strong>" . esc_html($space) . "</strong> (" . esc_html($duration) . ")<br>";
            echo "Date: " . esc_html($date) . "<br>";
            echo "Total: " . esc_html($price);
            break;
        case 'status':
            $status = get_post_meta($post_id, 'kc_status', true);
            if (!$status) $status = 'Pending';
            
            $bg = '#fef08a'; $color = '#854d0e'; // Pending
            if ($status === 'Contacted') { $bg = '#bfdbfe'; $color = '#1e3a8a'; }
            if ($status === 'Active')    { $bg = '#d1fae5'; $color = '#065f46'; }
            if ($status === 'Completed') { $bg = '#bbf7d0'; $color = '#166534'; }
            if ($status === 'Rejected' || $status === 'Cancelled') { $bg = '#fecaca'; $color = '#991b1b'; }

            echo "<select class='kc-inline-status-select' data-post-id='{$post_id}' data-post-type='kc_booking' style='background-color: {$bg}; color: {$color}; border: 1px solid {$color}; font-weight: 600; font-size:12px; padding:2px 24px 2px 8px; height:auto; min-height:26px; border-radius:4px;'>";
            $options = ['Pending', 'Contacted', 'Active', 'Completed', 'Rejected', 'Cancelled'];
            foreach ($options as $opt) {
                echo "<option value='{$opt}' style='background-color:#fff; color:#000;' " . selected($status, $opt, false) . ">{$opt}</option>";
            }
            echo "</select>";
            echo "<span class='kc-inline-status-spinner spinner' id='kc-spinner-{$post_id}' style='float:none; margin:0 0 0 5px;'></span>";
            break;
        case 'invoice':
            $inv = get_post_meta($post_id, 'kc_invoice_number', true);
            if ($inv) {
                echo "<code style='font-size:11px; background:#FFF9EF; border:1px solid rgba(189,69,31,0.25); padding:2px 6px; border-radius:3px; color:#AC201A; font-weight:700; white-space:nowrap;'>" . esc_html($inv) . "</code>";
            } else {
                echo "<span style='color:#cbd5e1; font-size:12px;'>—</span>";
            }
            break;
        case 'membership':
            $mem_status = get_post_meta($post_id, 'kc_membership_status', true);
            $mem_expiry = get_post_meta($post_id, 'kc_membership_expiry', true);
            if ($mem_status === 'Active') {
                echo "<span style='color: #d97706; font-weight: bold;'>Active Member</span><br>";
                echo "<small>Expires: " . esc_html($mem_expiry) . "</small>";
            } elseif ($mem_status === 'Expired') {
                echo "<span style='color: #9ca3af;'>Expired</span>";
            } else {
                echo "<span style='color: #9ca3af;'>N/A</span>";
            }
            break;
    }
}
add_action('manage_kc_booking_posts_custom_column', 'kc_custom_kc_booking_column', 10, 2);

// --- Invoice number search ---
// Extend WP admin search to also match kc_invoice_number and kc_email meta fields
add_filter('posts_search', 'kc_booking_extend_search', 10, 2);
function kc_booking_extend_search($search, $query) {
    global $wpdb;

    if (!is_admin() || !$query->is_main_query()) return $search;
    if ($query->get('post_type') !== 'kc_booking') return $search;

    $term = $query->get('s');
    if (empty($term)) return $search;

    // Already has a search clause — append an OR for meta fields
    $like = '%' . $wpdb->esc_like($term) . '%';
    $search .= $wpdb->prepare(
        " OR ( {$wpdb->posts}.ID IN (
            SELECT post_id FROM {$wpdb->postmeta}
            WHERE meta_key IN ('kc_invoice_number', 'kc_email', 'kc_first_name', 'kc_last_name', 'kc_phone')
            AND meta_value LIKE %s
          )
        )",
        $like
    );

    return $search;
}

// Prevent WP from ignoring our extended search when s is set
add_filter('posts_distinct', 'kc_booking_search_distinct', 10, 2);
function kc_booking_search_distinct($distinct, $query) {
    if (!is_admin() || !$query->is_main_query()) return $distinct;
    if ($query->get('post_type') !== 'kc_booking') return $distinct;
    if (empty($query->get('s'))) return $distinct;
    return 'DISTINCT';
}

// --- Admin CSS for SaaS UI ---

function kc_booking_admin_styles($hook) {
    global $post;
    if ($hook == 'post.php' || $hook == 'post-new.php') {
        if ('kc_booking' === $post->post_type) {
            ?>
            <style>
                /* Hide Default Title bar since it's just the name */
                #titlediv { display: none; }
                
                /* Clean up Meta Box borders */
                #poststuff .postbox {
                    border: none;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
                    background: #fff;
                    margin-bottom: 20px;
                }
                #poststuff .postbox h2.hndle {
                    border-bottom: 1px solid #f1f5f9;
                    font-size: 15px;
                    font-weight: 600;
                    padding: 15px 20px;
                    color: #1e293b;
                    background: transparent;
                }
                #poststuff .inside {
                    padding: 20px;
                    margin: 0;
                }

                /* Panel Layouts */
                .kc-panel-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 15px;
                }
                .kc-panel-field {
                    background: #f8fafc;
                    padding: 12px 15px;
                    border-radius: 6px;
                    border: 1px solid #e2e8f0;
                }
                .kc-panel-label {
                    display: block;
                    font-size: 11px;
                    text-transform: uppercase;
                    color: #64748b;
                    font-weight: 700;
                    margin-bottom: 4px;
                    letter-spacing: 0.5px;
                }
                .kc-panel-value {
                    font-size: 14px;
                    color: #0f172a;
                    font-weight: 500;
                }
                .kc-panel-value a {
                    text-decoration: none;
                    color: #d85c49;
                }
                .kc-panel-value a:hover {
                    text-decoration: underline;
                }
                
                /* Financial Highlight */
                .kc-financial-highlight {
                    background: #fdf6e3; /* Muted gold tint */
                    border-color: #f1d392;
                }
                .kc-financial-highlight .kc-panel-value {
                    color: #b58d3d;
                    font-size: 18px;
                    font-weight: 700;
                }

                /* Status Dropdown Styling */
                .kc-status-select {
                    width: 100%;
                    padding: 10px;
                    border-radius: 6px;
                    border: 1px solid #cbd5e1;
                    font-weight: 600;
                    font-size: 14px;
                }
                .kc-status-desc {
                    font-size: 12px;
                    color: #64748b;
                    margin-top: 8px;
                    line-height: 1.4;
                }

                /* Admin Notes */
                .kc-admin-note-area {
                    width: 100%;
                    border: 1px solid #cbd5e1;
                    border-radius: 6px;
                    padding: 12px;
                    font-size: 13px;
                    font-family: inherit;
                    background: #f8fafc;
                    min-height: 100px;
                }
                
                /* Membership Box */
                .kc-membership-badge {
                    display: inline-block;
                    padding: 6px 12px;
                    border-radius: 20px;
                    font-weight: 600;
                    font-size: 12px;
                    margin-bottom: 5px;
                }
                .kc-badge-active { background: #fef3c7; color: #d97706; }
                .kc-badge-expired { background: #f1f5f9; color: #64748b; }
            </style>
            <?php
        }
    }
}
add_action('admin_enqueue_scripts', 'kc_booking_admin_styles');


// --- Meta Boxes ---

function kc_add_booking_meta_boxes() {
    // Left Column (normal)
    add_meta_box('kc_booking_client', 'Client Information', 'kc_render_client_meta_box', 'kc_booking', 'normal', 'high');
    add_meta_box('kc_booking_specs', 'Booking Details', 'kc_render_specs_meta_box', 'kc_booking', 'normal', 'high');
    add_meta_box('kc_booking_special', 'Special Requests', 'kc_render_special_meta_box', 'kc_booking', 'normal', 'high');
    
    // Right Column (side)
    add_meta_box('kc_booking_status',      'Booking Status & Actions', 'kc_render_status_meta_box',      'kc_booking', 'side', 'high');
    add_meta_box('kc_booking_change_pass', 'Change Pass / Duration',  'kc_render_change_pass_meta_box', 'kc_booking', 'side', 'high');
    add_meta_box('kc_booking_payment',     'Payment Tracker',         'kc_render_payment_meta_box',     'kc_booking', 'side', 'high');
    add_meta_box('kc_booking_membership',  'Membership Tracker',      'kc_render_membership_meta_box',  'kc_booking', 'side', 'core');
}
add_action('add_meta_boxes', 'kc_add_booking_meta_boxes');

// 1. Client Info Panel (editable)
function kc_render_client_meta_box($post) {
    $fname     = get_post_meta($post->ID, 'kc_first_name', true);
    $lname     = get_post_meta($post->ID, 'kc_last_name',  true);
    $email     = get_post_meta($post->ID, 'kc_email',      true);
    $phone     = get_post_meta($post->ID, 'kc_phone',      true);
    $birthdate = get_post_meta($post->ID, 'kc_birthdate',  true);
    ?>
    <style>
        .kc-client-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .kc-client-field label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #94a3b8; margin-bottom: 5px; }
        .kc-client-field input { width: 100%; padding: 7px 10px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 13px; color: #2B2B2B; background: #fafafa; }
        .kc-client-field input:focus { border-color: #BD451F; outline: none; background: #fff; }
        .kc-client-hint { font-size: 11px; color: #94a3b8; margin: 10px 0 0; font-style: italic; }
    </style>

    <div class="kc-client-grid">
        <div class="kc-client-field">
            <label><span class="dashicons dashicons-admin-users" style="font-size:13px;vertical-align:middle;margin-right:3px;"></span> First Name</label>
            <input type="text" name="kc_first_name" value="<?php echo esc_attr($fname); ?>" placeholder="First name" />
        </div>
        <div class="kc-client-field">
            <label><span class="dashicons dashicons-admin-users" style="font-size:13px;vertical-align:middle;margin-right:3px;"></span> Last Name</label>
            <input type="text" name="kc_last_name" value="<?php echo esc_attr($lname); ?>" placeholder="Last name" />
        </div>
        <div class="kc-client-field">
            <label><span class="dashicons dashicons-email-alt" style="font-size:13px;vertical-align:middle;margin-right:3px;"></span> Email Address</label>
            <input type="email" name="kc_email" value="<?php echo esc_attr($email); ?>" placeholder="email@example.com" />
        </div>
        <div class="kc-client-field">
            <label><span class="dashicons dashicons-phone" style="font-size:13px;vertical-align:middle;margin-right:3px;"></span> Phone Number</label>
            <input type="text" name="kc_phone" value="<?php echo esc_attr($phone); ?>" placeholder="+63 9XX XXX XXXX" />
        </div>
        <div class="kc-client-field">
            <label><span class="dashicons dashicons-calendar-alt" style="font-size:13px;vertical-align:middle;margin-right:3px;"></span> Date of Birth</label>
            <input type="date" name="kc_birthdate" value="<?php echo esc_attr($birthdate); ?>" />
        </div>
    </div>
    <p class="kc-client-hint">Changes are saved when you click <strong>Update</strong>. Email and birthdate changes automatically sync to the Mailing List.</p>
    <?php
}

// 2. Booking Specs Panel
function kc_render_specs_meta_box($post) {
    $space        = get_post_meta($post->ID, 'kc_space_type',      true);
    $duration     = get_post_meta($post->ID, 'kc_duration',        true);
    $start_date   = get_post_meta($post->ID, 'kc_start_date',      true);
    $arrival      = get_post_meta($post->ID, 'kc_arrival_time',    true);
    $participants = get_post_meta($post->ID, 'kc_participants',     true);
    $promo_code   = get_post_meta($post->ID, 'kc_promo_code',      true);
    $discount     = get_post_meta($post->ID, 'kc_discount_amount', true);
    ?>
    <div class="kc-panel-grid">
        <div class="kc-panel-field">
            <span class="kc-panel-label">Target Space</span>
            <span class="kc-panel-value"><?php echo esc_html($space); ?></span>
        </div>
        <div class="kc-panel-field">
            <span class="kc-panel-label">Pass / Duration Type</span>
            <span class="kc-panel-value"><?php echo esc_html($duration); ?></span>
        </div>
        <div class="kc-panel-field">
            <span class="kc-panel-label">Selected Date</span>
            <span class="kc-panel-value"><?php echo esc_html($start_date); ?></span>
        </div>
        <div class="kc-panel-field">
            <span class="kc-panel-label">Arrival Time</span>
            <span class="kc-panel-value"><?php echo esc_html($arrival); ?></span>
        </div>
        <div class="kc-panel-field">
            <span class="kc-panel-label">Headcount</span>
            <span class="kc-panel-value"><?php echo esc_html($participants); ?> Participant(s)</span>
        </div>
        <?php if (!empty($promo_code)): ?>
        <div class="kc-panel-field">
            <span class="kc-panel-label">Promo Code Used</span>
            <span class="kc-panel-value" style="color:#10b981; font-weight:bold;"><?php echo esc_html($promo_code); ?></span>
        </div>
        <div class="kc-panel-field">
            <span class="kc-panel-label">Discount Amount</span>
            <span class="kc-panel-value">- Php <?php echo esc_html(number_format((float) $discount)); ?></span>
        </div>
        <?php endif; ?>
    </div>
    <?php
}

// 2b. Change Pass / Duration sidebar box
function kc_render_change_pass_meta_box($post) {
    $space    = get_post_meta($post->ID, 'kc_space_type',      true);
    $duration = get_post_meta($post->ID, 'kc_duration',        true);
    $price    = get_post_meta($post->ID, 'kc_price',           true);
    $discount = (float) get_post_meta($post->ID, 'kc_discount_amount', true);

    // Load pricing options via direct SQL
    $pricing_options = [];
    if (!empty($space)) {
        global $wpdb;
        $space_post_id = $wpdb->get_var($wpdb->prepare(
            "SELECT pm.post_id FROM {$wpdb->postmeta} pm
             INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
             WHERE pm.meta_key = 'kc_space_booking_key'
               AND pm.meta_value = %s
               AND p.post_type = 'kc_space'
               AND p.post_status = 'publish'
             LIMIT 1",
            $space
        ));
        if ($space_post_id) {
            $raw = get_post_meta((int) $space_post_id, 'kc_space_pricing_options', true);
            foreach (array_filter(array_map('trim', explode("\n", $raw ?: ''))) as $line) {
                $parts = array_map('trim', explode('|', $line));
                if (count($parts) >= 3) {
                    $pricing_options[] = [
                        'label' => $parts[0],
                        'value' => $parts[1],
                        'price' => (float) preg_replace('/[^0-9.]/', '', $parts[2]),
                    ];
                }
            }
        }
    }

    if (empty($pricing_options)) {
        echo '<p style="font-size:12px; color:#94a3b8; font-style:italic;">No pricing options found for this space.</p>';
        return;
    }
    ?>
    <style>
        .kc-change-pass-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; margin-bottom:5px; display:block; }
        .kc-change-pass-select { width:100%; padding:6px 8px; border:1px solid #e2e8f0; border-radius:4px; font-size:12px; color:#0f172a; box-sizing:border-box; }
        .kc-change-pass-preview { margin-top:10px; padding:8px 10px; background:#FFF9EF; border:1px solid rgba(189,69,31,0.2); border-radius:4px; font-size:12px; }
        .kc-change-pass-preview .label { color:#64748b; }
        .kc-change-pass-preview .val   { font-weight:700; color:#AC201A; font-size:14px; }
        .kc-change-pass-hint { font-size:11px; color:#94a3b8; margin:6px 0 0; line-height:1.5; }
    </style>

    <span class="kc-change-pass-label">Select New Pass Type</span>
    <select name="kc_duration" id="kc_duration_select" class="kc-change-pass-select">
        <?php foreach ($pricing_options as $opt): ?>
        <option value="<?php echo esc_attr($opt['value']); ?>"
                data-price="<?php echo esc_attr($opt['price']); ?>"
                <?php selected($duration, $opt['value']); ?>>
            <?php echo esc_html($opt['label']); ?>
        </option>
        <?php endforeach; ?>
    </select>

    <div class="kc-change-pass-preview">
        <span class="label">New Total Due&nbsp;&nbsp;</span>
        <span class="val" id="kc_price_display">Php <?php echo number_format((float) $price, 2); ?></span>
    </div>
    <input type="hidden" name="kc_price_override" id="kc_price_override" value="">
    <p class="kc-change-pass-hint">Changing the pass type updates the total due. Click <strong>Update</strong> to save. Existing payments in the Payment Tracker are kept — only the total changes.</p>

    <script>
    (function () {
        var sel      = document.getElementById('kc_duration_select');
        var display  = document.getElementById('kc_price_display');
        var override = document.getElementById('kc_price_override');
        var discount = <?php echo $discount; ?>;

        if (!sel) return;

        sel.addEventListener('change', function () {
            var opt   = sel.options[sel.selectedIndex];
            var base  = parseFloat(opt.getAttribute('data-price')) || 0;
            var total = Math.max(0, base - discount);
            display.textContent = 'Php ' + total.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            override.value = total;
        });
    })();
    </script>
    <?php
}

// 3. Special Requests Panel
function kc_render_special_meta_box($post) {
    $special = get_post_meta($post->ID, 'kc_special', true);
    ?>
    <div style="background:#fef2f2; border:1px solid #fecaca; padding:15px; border-radius:6px; color:#7f1d1d; font-size:14px; line-height:1.6;">
        <?php echo !empty($special) ? nl2br(esc_html($special)) : '<em>No special requests provided by the client.</em>'; ?>
    </div>
    <?php
}

// 4. Status Panel (Right)
function kc_render_status_meta_box($post) {
    wp_nonce_field('kc_save_booking_data', 'kc_booking_nonce');
    $status = get_post_meta($post->ID, 'kc_status', true);
    if (!$status) $status = 'Pending';
    ?>
    <select name="kc_status" id="kc_status" class="kc-status-select">
        <option value="Pending"   <?php selected($status, 'Pending');   ?>>Pending</option>
        <option value="Contacted" <?php selected($status, 'Contacted'); ?>>Contacted / Confirmed</option>
        <option value="Active"    <?php selected($status, 'Active');    ?>>Active</option>
        <option value="Completed" <?php selected($status, 'Completed'); ?>>Completed</option>
        <option value="Rejected"  <?php selected($status, 'Rejected');  ?>>Rejected</option>
        <option value="Cancelled" <?php selected($status, 'Cancelled'); ?>>Cancelled</option>
    </select>
    <p class="kc-status-desc">
        <strong>Automations:</strong><br>
        • <em>Contacted</em> instantly emails a confirmation to the client.<br>
        • <em>Active</em> means the client is currently using the space — activates membership for monthly/annual passes.<br>
        • <em>Completed</em> means the booking period is fully over — also activates membership if not already done.<br>
        • <em>Rejected</em> automatically sends a rejection email to the client. No reason required.
    </p>
    <?php
}

// 5. Membership Panel (Right)
function kc_render_membership_meta_box($post) {
    $mem_status = get_post_meta($post->ID, 'kc_membership_status', true);
    $mem_expiry = get_post_meta($post->ID, 'kc_membership_expiry', true);
    $today      = date('Y-m-d');

    // Auto-correct status if expiry has already passed
    if ($mem_status === 'Active' && $mem_expiry && $mem_expiry < $today) {
        update_post_meta($post->ID, 'kc_membership_status', 'Expired');
        $mem_status = 'Expired';
    }

    $space    = get_post_meta($post->ID, 'kc_space_type',  true);
    $duration = get_post_meta($post->ID, 'kc_duration',    true);
    $fname    = get_post_meta($post->ID, 'kc_first_name',  true);
    $lname    = get_post_meta($post->ID, 'kc_last_name',   true);
    $email    = get_post_meta($post->ID, 'kc_client_email', true);

    $renew_nonce = wp_create_nonce('kc_renew_booking_' . $post->ID);

    if ($mem_status === 'Active') {
        $expiry_fmt = $mem_expiry ? date_i18n('F j, Y', strtotime($mem_expiry)) : $mem_expiry;
        echo '<div class="kc-membership-badge kc-badge-active">Active Member</div>';
        echo '<div style="font-size:13px; color:#475569; margin-top:5px;">Valid until: <strong>' . esc_html($expiry_fmt) . '</strong></div>';
    } elseif ($mem_status === 'Expired') {
        $expiry_fmt = $mem_expiry ? date_i18n('F j, Y', strtotime($mem_expiry)) : $mem_expiry;
        echo '<div class="kc-membership-badge kc-badge-expired">Expired Member</div>';
        echo '<div style="font-size:13px; color:#475569; margin-top:5px;">Expired on: ' . esc_html($expiry_fmt) . '</div>';
    } else {
        echo '<div style="font-size:13px; color:#64748b; font-style:italic;">This booking does not include a monthly/annual membership, or the booking is not yet completed.</div>';
    }

    // Show Continue Pass button only for Active or Expired memberships
    if (in_array($mem_status, ['Active', 'Expired'])) {
        $continue_nonce = wp_create_nonce('kc_continue_pass_' . $post->ID);
        $is_monthly     = stripos($duration, 'Month') !== false;
        $period_label   = $is_monthly ? '1 Month' : '1 Year';
        ?>
        <hr style="border:0; border-top:1px solid rgba(189,69,31,0.15); margin:12px 0;">
        <div style="font-size:12px; color:#64748b; margin-bottom:8px;">
            Extend this client's pass by <strong><?php echo esc_html($period_label); ?></strong> from the current expiry date. No new booking is created — the expiry date is simply pushed forward and membership stays Active.
        </div>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action"       value="kc_continue_pass">
            <input type="hidden" name="booking_id"   value="<?php echo esc_attr($post->ID); ?>">
            <input type="hidden" name="_wpnonce"     value="<?php echo esc_attr($continue_nonce); ?>">
            <button type="submit" class="button button-primary" style="width:100%; background:#BD451F; border-color:#AC201A; color:#fff; font-weight:700; font-size:12px; padding:7px 0; cursor:pointer;">
                Continue Pass (+ <?php echo esc_html($period_label); ?>)
            </button>
        </form>
        <?php
    }
}

// 6. Admin Notes Panel — removed; rejection email no longer requires a manual reason.


// 7. Payment Tracker Panel (Right)
function kc_render_payment_meta_box($post) {
    $total_due   = (float) get_post_meta($post->ID, 'kc_price', true);
    $log_raw     = get_post_meta($post->ID, 'kc_payment_log', true);
    $log         = is_array($log_raw) ? $log_raw : [];
    $total_paid  = array_sum(array_column($log, 'amount'));
    $balance     = max(0, $total_due - $total_paid);
    $inv_number  = get_post_meta($post->ID, 'kc_invoice_number', true);

    if ($balance <= 0 && $total_paid > 0) {
        $pay_status = 'Fully Paid';
        $pay_color  = '#22c55e';
    } elseif ($total_paid > 0) {
        $pay_status = 'Partially Paid';
        $pay_color  = '#f59e0b';
    } else {
        $pay_status = 'Unpaid';
        $pay_color  = '#ef4444';
    }
    ?>
    <style>
        .kc-pay-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 0; border-bottom: 1px solid #f1f5f9; font-size: 12px; }
        .kc-pay-row:last-of-type { border-bottom: none; }
        .kc-pay-label { color: #64748b; font-weight: 600; }
        .kc-pay-val   { font-weight: 700; color: #0f172a; }
        .kc-pay-badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; color: #fff; }
        .kc-pay-input { width: 100%; padding: 6px 8px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 12px; margin-bottom: 6px; box-sizing: border-box; }
        .kc-pay-btn   { width: 100%; background: #AC201A; color: #fff; border: none; padding: 8px; font-weight: 700; font-size: 12px; cursor: pointer; border-radius: 4px; margin-top: 4px; }
        .kc-pay-btn:hover { background: #8E1510; }
        .kc-pay-history { margin-top: 10px; }
        .kc-pay-entry { font-size: 11px; padding: 5px 0; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .kc-pay-entry:last-child { border-bottom: none; }
        .kc-pay-entry strong { color: #22c55e; }
        .kc-pay-sep { border: 0; border-top: 1px solid rgba(189,69,31,0.15); margin: 10px 0; }
    </style>

    <?php if ($inv_number): ?>
    <div style="font-size:11px; color:#94a3b8; margin-bottom:8px;">Invoice: <strong style="color:#BD451F;"><?php echo esc_html($inv_number); ?></strong></div>
    <?php endif; ?>

    <div class="kc-pay-row">
        <span class="kc-pay-label">Total Amount Due</span>
        <span class="kc-pay-val">Php <?php echo number_format($total_due, 2); ?></span>
    </div>
    <div class="kc-pay-row">
        <span class="kc-pay-label">Total Paid</span>
        <span class="kc-pay-val" style="color:#22c55e;">Php <?php echo number_format($total_paid, 2); ?></span>
    </div>
    <div class="kc-pay-row">
        <span class="kc-pay-label">Remaining Balance</span>
        <span class="kc-pay-val" style="color:<?php echo esc_attr($pay_color); ?>;">Php <?php echo number_format($balance, 2); ?></span>
    </div>
    <div class="kc-pay-row" style="border-bottom:none; margin-bottom:6px;">
        <span class="kc-pay-label">Payment Status</span>
        <span class="kc-pay-badge" style="background:<?php echo esc_attr($pay_color); ?>;"><?php echo esc_html($pay_status); ?></span>
    </div>

    <hr class="kc-pay-sep">

    <div style="font-size:11px; font-weight:700; color:#64748b; margin-bottom:6px; text-transform:uppercase; letter-spacing:.5px;">Add Payment</div>
    <input type="number" id="kc-pay-amount" class="kc-pay-input" placeholder="Amount (e.g. 5000)" min="1" step="0.01" />
    <input type="text"   id="kc-pay-note"   class="kc-pay-input" placeholder="Note / Ref # (e.g. Cash, GCash ref 12345)" />
    <label style="font-size:11px; color:#475569; display:flex; align-items:center; gap:5px; margin-bottom:6px;">
        <input type="checkbox" id="kc-pay-send-receipt" checked />
        Send payment receipt email to client
    </label>
    <button type="button" class="kc-pay-btn" id="kc-pay-add-btn" data-post-id="<?php echo esc_attr($post->ID); ?>">Add Payment</button>
    <div id="kc-pay-result" style="font-size:11px; margin-top:6px; font-weight:600;"></div>

    <?php if (!empty($log)): ?>
    <hr class="kc-pay-sep">
    <div style="font-size:11px; font-weight:700; color:#64748b; margin-bottom:4px; text-transform:uppercase; letter-spacing:.5px;">Payment History</div>
    <div class="kc-pay-history">
        <?php foreach (array_reverse($log) as $entry): ?>
        <div class="kc-pay-entry">
            <strong>+ Php <?php echo number_format((float)$entry['amount'], 2); ?></strong>
            &nbsp;<?php echo esc_html($entry['date']); ?>
            <?php if (!empty($entry['note'])): ?>&nbsp;&mdash; <?php echo esc_html($entry['note']); ?><?php endif; ?>
            <span style="color:#94a3b8;"> by <?php echo esc_html($entry['by']); ?></span>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <script>
    jQuery(document).ready(function($) {
        $('#kc-pay-add-btn').on('click', function() {
            var btn        = $(this);
            var amount     = parseFloat($('#kc-pay-amount').val());
            var note       = $('#kc-pay-note').val();
            var sendReceipt = $('#kc-pay-send-receipt').is(':checked') ? 1 : 0;
            var postId     = btn.data('post-id');
            var result     = $('#kc-pay-result');

            if (!amount || amount <= 0) {
                result.css('color', '#ef4444').text('Please enter a valid amount.');
                return;
            }

            btn.prop('disabled', true).text('Adding...');
            result.text('');

            $.post(ajaxurl, {
                action:      'kc_add_payment',
                nonce:       '<?php echo wp_create_nonce('kc_add_payment'); ?>',
                post_id:     postId,
                amount:      amount,
                note:        note,
                send_receipt: sendReceipt
            }, function(res) {
                btn.prop('disabled', false).text('Add Payment');
                if (res.success) {
                    result.css('color', '#22c55e').text(res.data.message);
                    // Reload to refresh all totals and history
                    setTimeout(function() { location.reload(); }, 800);
                } else {
                    result.css('color', '#ef4444').text(res.data.message || 'Error adding payment.');
                }
            });
        });
    });
    </script>
    <?php
}

// --- Save Logic & Automations ---

// --- Helper Function for Booking Emails ---
function kc_send_booking_email($post_id, $template_type) {
    $fname = get_post_meta($post_id, 'kc_first_name', true);
    $lname = get_post_meta($post_id, 'kc_last_name', true);
    $email = get_post_meta($post_id, 'kc_email', true);
    $space = get_post_meta($post_id, 'kc_space_type', true);
    $duration = get_post_meta($post_id, 'kc_duration', true);
    $price = get_post_meta($post_id, 'kc_price', true);
    $date = get_post_meta($post_id, 'kc_start_date', true);
    $arrival = get_post_meta($post_id, 'kc_arrival_time', true);
    $participants = get_post_meta($post_id, 'kc_participants', true);
    $special = get_post_meta($post_id, 'kc_special', true);
    $admin_note = get_post_meta($post_id, 'kc_admin_note', true);
    
    if (empty($email)) return;

    $prefix = 'kc_' . $template_type . '_';
    $subject_template = get_option($prefix . 'subject', '');
    $heading_template = get_option($prefix . 'heading', '');
    $body_template    = get_option($prefix . 'body', '');
    $banner_template  = get_option($prefix . 'banner', '');
    $btn_text         = get_option($prefix . 'btn_text', '');
    $btn_url_template = get_option($prefix . 'btn_url', '');

    if (empty($subject_template) && $template_type === 'booking_confirmed') {
        $subject_template = 'Your Kings City Booking is Confirmed!';
        $heading_template = 'Booking Confirmation';
        $body_template = "Dear {fname},\n\nYour booking for the <strong>{space}</strong> has been successfully confirmed. We are thrilled to host you and your team. Please arrive on your chosen date and complete your payment at our front desk.\n\nIf you need to make any changes to your reservation, please reply directly to this correspondence. We look forward to seeing you soon!";
        $banner_template = "We've prepared some important information and updates for your upcoming visit. Please review this before you arrive.";
        $btn_text = 'View Newsletter';
        $btn_url_template = '{packet_url}';
    }

    $send_packet = false;
    $packet_url = '';
    
    if ($template_type === 'booking_confirmed') {
        $active_newsletters = get_posts(array(
            'post_type'      => 'kc_welcome_packet',
            'posts_per_page' => 1,
            'meta_query'     => array(
                array(
                    'key'     => 'kc_is_active',
                    'value'   => '1',
                    'compare' => '=='
                )
            ),
            'fields'         => 'ids',
        ));
        $active_packet_id = !empty($active_newsletters) ? $active_newsletters[0] : false;

        if ($active_packet_id) {
            $past_bookings = get_posts(array(
                'post_type'      => 'kc_booking',
                'posts_per_page' => -1,
                'meta_key'       => 'kc_email',
                'meta_value'     => get_post_meta($post_id, 'kc_email', true),
                'fields'         => 'ids',
            ));

            $has_received = false;
            foreach ($past_bookings as $pb_id) {
                $pb_received = get_post_meta($pb_id, 'kc_received_packet_ids', true);
                if (is_array($pb_received) && in_array($active_packet_id, $pb_received)) {
                    $has_received = true;
                    break;
                }
            }

            if (!$has_received) {
                $send_packet = true;
                $packet_url = function_exists('get_field') ? get_field('kc_packet_url', $active_packet_id) : get_post_meta($active_packet_id, 'kc_packet_url', true);
                
                $received_packets = get_post_meta($post_id, 'kc_received_packet_ids', true);
                if (!is_array($received_packets)) $received_packets = array();
                $received_packets[] = $active_packet_id;
                update_post_meta($post_id, 'kc_received_packet_ids', $received_packets);
            }
        }
    }

    $tokens = array(
        '{fname}' => $fname,
        '{lname}' => $lname,
        '{space}' => $space,
        '{date}' => $date,
        '{duration}' => $duration,
        '{price}' => $price,
        '{arrival}' => $arrival,
        '{participants}' => $participants,
        '{special}' => $special,
        '{admin_note}' => $admin_note,
        '{packet_url}' => $packet_url,
        '{site_url}' => site_url()
    );

    $subject = strtr($subject_template, $tokens);
    $email_heading = strtr($heading_template, $tokens);
    $email_body = wpautop(strtr($body_template, $tokens));
    $email_banner = strtr($banner_template, $tokens);
    $email_btn_text = $btn_text;
    $email_btn_url = strtr($btn_url_template, $tokens);

    $hide_table = ($template_type !== 'booking_confirmed');

    // The logic to send packet is moved up.

    ob_start();
    include get_template_directory() . '/emails/email-booking-confirmed.php';
    $message = ob_get_clean();

    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($email, $subject, $message, $headers);
}

function kc_process_booking_status_change($post_id, $new_status, $old_status) {
    if ($old_status === $new_status) return;

    update_post_meta($post_id, 'kc_status', $new_status);
    
    $email = get_post_meta($post_id, 'kc_email', true);
    $fname = get_post_meta($post_id, 'kc_first_name', true);
    $space = get_post_meta($post_id, 'kc_space_type', true);
    $date = get_post_meta($post_id, 'kc_start_date', true);
    $duration = get_post_meta($post_id, 'kc_duration', true);
    $price = get_post_meta($post_id, 'kc_price', true);
    $arrival = get_post_meta($post_id, 'kc_arrival_time', true);
    $participants = get_post_meta($post_id, 'kc_participants', true);
    $special = get_post_meta($post_id, 'kc_special', true);
    $note = get_post_meta($post_id, 'kc_admin_note', true);

    // 1. Email Logic
    if ($new_status === 'Contacted') {
        kc_send_booking_email($post_id, 'booking_confirmed');
    } elseif ($new_status === 'Active') {
        // Generate invoice number if not yet set, then send invoice
        $inv_number = get_post_meta($post_id, 'kc_invoice_number', true);
        if (empty($inv_number)) {
            $counter    = (int) get_option('kc_invoice_counter', 0) + 1;
            update_option('kc_invoice_counter', $counter);
            $inv_number = 'KC-INV-' . date('Y') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);
            update_post_meta($post_id, 'kc_invoice_number', $inv_number);
        }
        kc_send_invoice_email($post_id, $inv_number);
    } elseif ($new_status === 'Rejected') {
        kc_send_booking_email($post_id, 'booking_rejected');
    }

    // 2. Membership Expiration Logic — triggers on Active OR Completed (whichever comes first)
    if (in_array($new_status, ['Active', 'Completed'])) {
        $already_active = get_post_meta($post_id, 'kc_membership_status', true) === 'Active';
        if (!$already_active) {
            $start_timestamp = strtotime($date);
            if (!$start_timestamp) $start_timestamp = time();

            // Check the space CPT flag — only spaces marked as membership-supporting get a membership record
            $space_post_id = $wpdb->get_var($wpdb->prepare(
                "SELECT pm.post_id FROM {$wpdb->postmeta} pm
                 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                 WHERE pm.meta_key = 'kc_space_booking_key'
                   AND pm.meta_value = %s
                   AND p.post_type = 'kc_space'
                   AND p.post_status = 'publish'
                 LIMIT 1",
                $space
            ));
            $has_membership = $space_post_id
                ? (bool) get_post_meta((int) $space_post_id, 'kc_space_has_membership', true)
                : false;

            if ($has_membership) {
                if (stripos($duration, 'Month') !== false) {
                    $expiry = date('Y-m-d', strtotime('+1 month', $start_timestamp));
                } else {
                    // Annual / Year
                    $expiry = date('Y-m-d', strtotime('+1 year', $start_timestamp));
                }
                update_post_meta($post_id, 'kc_membership_status', 'Active');
                update_post_meta($post_id, 'kc_membership_expiry', $expiry);
            } else {
                update_post_meta($post_id, 'kc_membership_status', 'N/A');
            }
        }
    }
}

function kc_save_booking_meta($post_id) {
    if (!isset($_POST['kc_booking_nonce']) || !wp_verify_nonce($_POST['kc_booking_nonce'], 'kc_save_booking_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id) && !current_user_can('edit_kc_bookings')) return;

    // ── Client info fields ──
    $old_email     = get_post_meta($post_id, 'kc_email',     true);
    $old_birthdate = get_post_meta($post_id, 'kc_birthdate', true);

    if (isset($_POST['kc_first_name'])) {
        update_post_meta($post_id, 'kc_first_name', sanitize_text_field($_POST['kc_first_name']));
    }
    if (isset($_POST['kc_last_name'])) {
        update_post_meta($post_id, 'kc_last_name', sanitize_text_field($_POST['kc_last_name']));
    }
    if (isset($_POST['kc_phone'])) {
        update_post_meta($post_id, 'kc_phone', sanitize_text_field($_POST['kc_phone']));
    }

    $new_email     = isset($_POST['kc_email'])     ? sanitize_email($_POST['kc_email'])         : $old_email;
    $new_birthdate = isset($_POST['kc_birthdate']) ? sanitize_text_field($_POST['kc_birthdate']) : $old_birthdate;

    if (!empty($new_email)) {
        update_post_meta($post_id, 'kc_email', $new_email);
    }
    if (isset($_POST['kc_birthdate'])) {
        $bd_val = preg_match('/^\d{4}-\d{2}-\d{2}$/', $new_birthdate) ? $new_birthdate : null;
        update_post_meta($post_id, 'kc_birthdate', $bd_val);
    }

    // ── Cascade email + birthdate changes to the mailing list ──
    if (!empty($new_email)) {
        global $wpdb;
        $ml_table  = $wpdb->prefix . 'kc_mailing_list';
        $bd_synced = isset($bd_val) ? $bd_val : $new_birthdate;

        $ml_row = $wpdb->get_row($wpdb->prepare("SELECT id FROM {$ml_table} WHERE email = %s", $old_email));

        if ($ml_row) {
            // Row exists for the old email — update email + birthdate together
            $wpdb->update(
                $ml_table,
                array('email' => $new_email, 'birthdate' => $bd_synced ?: null),
                array('id'    => $ml_row->id),
                array('%s', '%s'),
                array('%d')
            );
        } elseif ($new_email !== $old_email) {
            // Old email wasn't in the list — check if new email already is
            $new_row = $wpdb->get_row($wpdb->prepare("SELECT id FROM {$ml_table} WHERE email = %s", $new_email));
            if ($new_row) {
                // New email already in list — just sync the birthdate
                $wpdb->update(
                    $ml_table,
                    array('birthdate' => $bd_synced ?: null),
                    array('id'        => $new_row->id),
                    array('%s'),
                    array('%d')
                );
            }
            // If neither email is in the list, do nothing — they haven't subscribed
        } else {
            // Email unchanged, birthdate may have changed — sync it if row exists for current email
            $cur_row = $wpdb->get_row($wpdb->prepare("SELECT id FROM {$ml_table} WHERE email = %s", $new_email));
            if ($cur_row) {
                $wpdb->update(
                    $ml_table,
                    array('birthdate' => $bd_synced ?: null),
                    array('id'        => $cur_row->id),
                    array('%s'),
                    array('%d')
                );
            }
        }
    }

    // ── Duration + price change ──
    if (isset($_POST['kc_duration'])) {
        $old_duration = get_post_meta($post_id, 'kc_duration', true);
        $new_duration = sanitize_text_field($_POST['kc_duration']);

        if ($new_duration !== $old_duration) {
            update_post_meta($post_id, 'kc_duration', $new_duration);

            // kc_price_override is set by JS when the admin changed the dropdown
            $price_override = isset($_POST['kc_price_override']) ? (float) $_POST['kc_price_override'] : 0;
            if ($price_override > 0) {
                update_post_meta($post_id, 'kc_price', $price_override);
            }

            // If membership is already Active, recalculate expiry from today with the new period
            $mem_status = get_post_meta($post_id, 'kc_membership_status', true);
            if ($mem_status === 'Active') {
                $base = date('Y-m-d');
                if (stripos($new_duration, 'Month') !== false) {
                    $new_expiry = date('Y-m-d', strtotime('+1 month', strtotime($base)));
                } else {
                    $new_expiry = date('Y-m-d', strtotime('+1 year', strtotime($base)));
                }
                update_post_meta($post_id, 'kc_membership_expiry', $new_expiry);
                // Reset reminder so client gets a fresh 7-day notice on new expiry
                delete_post_meta($post_id, 'kc_expiry_reminder_sent');
            }
        }
    }

    // ── Status change ──
    $old_status = get_post_meta($post_id, 'kc_status', true);
    $new_status = sanitize_text_field($_POST['kc_status'] ?? $old_status);
    if ($old_status !== $new_status) {
        kc_process_booking_status_change($post_id, $new_status, $old_status);
    }
}
add_action('save_post_kc_booking', 'kc_save_booking_meta');

// --- Invoice Email ---
function kc_send_invoice_email($post_id, $inv_number) {
    $fname        = get_post_meta($post_id, 'kc_first_name',      true);
    $lname        = get_post_meta($post_id, 'kc_last_name',       true);
    $email        = get_post_meta($post_id, 'kc_email',           true);
    $space        = get_post_meta($post_id, 'kc_space_type',      true);
    $duration     = get_post_meta($post_id, 'kc_duration',        true);
    $start_date   = get_post_meta($post_id, 'kc_start_date',      true);
    $arrival      = get_post_meta($post_id, 'kc_arrival_time',    true);
    $participants = get_post_meta($post_id, 'kc_participants',    true);
    $base_price   = (float) get_post_meta($post_id, 'kc_base_price',      true);
    $discount     = (float) get_post_meta($post_id, 'kc_discount_amount', true);
    $total_due    = (float) get_post_meta($post_id, 'kc_price',           true);
    $promo_code   = get_post_meta($post_id, 'kc_promo_code',      true);

    if (empty($email)) return;

    $tokens = [
        '{fname}'      => $fname,
        '{lname}'      => $lname,
        '{space}'      => $space,
        '{duration}'   => $duration,
        '{date}'       => $start_date,
        '{inv_number}' => $inv_number,
        '{site_url}'   => site_url(),
    ];

    $subject       = strtr(get_option('kc_booking_invoice_subject', 'Your Invoice from Kings City Club — {inv_number}'), $tokens);
    $email_heading = strtr(get_option('kc_booking_invoice_heading', 'Invoice'), $tokens);

    $email_promo_code = '';

    ob_start();
    include get_template_directory() . '/emails/email-invoice.php';
    $html = ob_get_clean();

    $headers = ['Content-Type: text/html; charset=UTF-8'];
    wp_mail($email, $subject, $html, $headers);
}

// --- Payment Receipt Email ---
function kc_send_payment_receipt_email($post_id, $amount, $note, $total_paid, $balance, $inv_number) {
    $fname     = get_post_meta($post_id, 'kc_first_name', true);
    $lname     = get_post_meta($post_id, 'kc_last_name',  true);
    $email     = get_post_meta($post_id, 'kc_email',      true);
    $space     = get_post_meta($post_id, 'kc_space_type', true);
    $duration  = get_post_meta($post_id, 'kc_duration',   true);
    $total_due = (float) get_post_meta($post_id, 'kc_price', true);

    if (empty($email)) return;

    $fully_paid = ($balance <= 0);

    $tokens = [
        '{fname}'      => $fname,
        '{lname}'      => $lname,
        '{space}'      => $space,
        '{duration}'   => $duration,
        '{inv_number}' => $inv_number,
        '{amount}'     => 'Php ' . number_format($amount, 2),
        '{balance}'    => 'Php ' . number_format($balance, 2),
        '{site_url}'   => site_url(),
    ];

    if ($fully_paid) {
        $subject       = strtr(get_option('kc_booking_payment_receipt_subject_paid',   'Your balance is fully settled — Kings City Club'), $tokens);
        $email_heading = strtr(get_option('kc_booking_payment_receipt_heading_paid',   'Payment Complete — Thank You!'), $tokens);
    } else {
        $subject       = strtr(get_option('kc_booking_payment_receipt_subject_partial', 'Payment received — Remaining balance {balance}'), $tokens);
        $email_heading = strtr(get_option('kc_booking_payment_receipt_heading_partial', 'Payment Received'), $tokens);
    }

    $email_promo_code = '';

    ob_start();
    include get_template_directory() . '/emails/email-payment-receipt.php';
    $html = ob_get_clean();

    $headers = ['Content-Type: text/html; charset=UTF-8'];
    wp_mail($email, $subject, $html, $headers);
}

// --- AJAX: Add Payment ---
add_action('wp_ajax_kc_add_payment', 'kc_ajax_add_payment');
function kc_ajax_add_payment() {
    check_ajax_referer('kc_add_payment', 'nonce');

    if (!current_user_can('edit_posts') && !current_user_can('edit_kc_bookings')) {
        wp_send_json_error(['message' => 'Permission denied.']);
    }

    $post_id     = (int) ($_POST['post_id'] ?? 0);
    $amount      = (float) ($_POST['amount'] ?? 0);
    $note        = sanitize_text_field($_POST['note'] ?? '');
    $send_receipt = (int) ($_POST['send_receipt'] ?? 0);

    if (!$post_id || $amount <= 0) {
        wp_send_json_error(['message' => 'Invalid payment data.']);
    }

    if (get_post_type($post_id) !== 'kc_booking') {
        wp_send_json_error(['message' => 'Invalid booking.']);
    }

    // Generate invoice number if not yet set
    $inv_number = get_post_meta($post_id, 'kc_invoice_number', true);
    if (empty($inv_number)) {
        $counter    = (int) get_option('kc_invoice_counter', 0) + 1;
        update_option('kc_invoice_counter', $counter);
        $inv_number = 'KC-INV-' . date('Y') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);
        update_post_meta($post_id, 'kc_invoice_number', $inv_number);
    }

    // Append to payment log
    $log = get_post_meta($post_id, 'kc_payment_log', true);
    if (!is_array($log)) $log = [];

    $log[] = [
        'amount' => $amount,
        'note'   => $note,
        'date'   => date_i18n('M j, Y g:i A'),
        'by'     => wp_get_current_user()->user_login,
    ];
    update_post_meta($post_id, 'kc_payment_log', $log);

    // Recalculate balance
    $total_due  = (float) get_post_meta($post_id, 'kc_price', true);
    $total_paid = array_sum(array_column($log, 'amount'));
    $balance    = max(0, $total_due - $total_paid);

    // Send receipt email if requested
    if ($send_receipt) {
        kc_send_payment_receipt_email($post_id, $amount, $note, $total_paid, $balance, $inv_number);
    }

    $msg = 'Payment of Php ' . number_format($amount, 2) . ' recorded.';
    if ($balance <= 0) {
        $msg .= ' Fully paid!';
    } else {
        $msg .= ' Remaining: Php ' . number_format($balance, 2) . '.';
    }

    wp_send_json_success(['message' => $msg]);
}

// Continue Pass: extends the expiry date on the existing booking (no new booking created)
add_action('admin_post_kc_continue_pass', 'kc_handle_continue_pass');
function kc_handle_continue_pass() {
    $booking_id = (int) ($_POST['booking_id'] ?? 0);
    if (!$booking_id || !check_admin_referer('kc_continue_pass_' . $booking_id)) {
        wp_die('Invalid request.');
    }
    if (!current_user_can('edit_posts') && !current_user_can('edit_kc_bookings')) {
        wp_die('Permission denied.');
    }
    if (get_post_type($booking_id) !== 'kc_booking') {
        wp_die('Invalid booking.');
    }

    $duration   = get_post_meta($booking_id, 'kc_duration', true);
    $old_expiry = get_post_meta($booking_id, 'kc_membership_expiry', true);

    // Extend from current expiry, or from today if already past
    $base = ($old_expiry && $old_expiry >= date('Y-m-d')) ? $old_expiry : date('Y-m-d');

    if (stripos($duration, 'Month') !== false) {
        $new_expiry = date('Y-m-d', strtotime('+1 month', strtotime($base)));
    } else {
        $new_expiry = date('Y-m-d', strtotime('+1 year', strtotime($base)));
    }

    update_post_meta($booking_id, 'kc_membership_expiry', $new_expiry);
    update_post_meta($booking_id, 'kc_membership_status', 'Active');
    // Clear the reminder flag so the client gets a fresh reminder on the new expiry cycle
    delete_post_meta($booking_id, 'kc_expiry_reminder_sent');

    wp_redirect(admin_url('post.php?post=' . $booking_id . '&action=edit&kc_continued=1'));
    exit;
}

// Show success notice after Continue Pass redirect
add_action('admin_notices', function () {
    if (!isset($_GET['kc_continued']) || get_current_screen()->post_type !== 'kc_booking') return;
    $booking_id = (int) ($_GET['post'] ?? 0);
    $expiry     = $booking_id ? get_post_meta($booking_id, 'kc_membership_expiry', true) : '';
    $expiry_fmt = $expiry ? date_i18n('F j, Y', strtotime($expiry)) : '';
    echo '<div class="notice notice-success is-dismissible"><p>';
    echo 'Pass continued successfully. New expiry date: <strong>' . esc_html($expiry_fmt) . '</strong>.';
    echo '</p></div>';
});

// When a booking is permanently deleted or trashed, clear the birthdate from
// the mailing list ONLY if no other active/pending booking exists for that email.
add_action('before_delete_post', 'kc_booking_delete_clean_mailing_list');
add_action('wp_trash_post',      'kc_booking_delete_clean_mailing_list');
function kc_booking_delete_clean_mailing_list($post_id) {
    if (get_post_type($post_id) !== 'kc_booking') return;

    $email = get_post_meta($post_id, 'kc_email', true);
    if (empty($email)) return;

    // Check if this subscriber has any OTHER bookings still alive
    $other_bookings = get_posts(array(
        'post_type'      => 'kc_booking',
        'post_status'    => array('publish', 'pending', 'draft'),
        'posts_per_page' => 1,
        'post__not_in'   => array($post_id),
        'meta_query'     => array(array(
            'key'   => 'kc_email',
            'value' => $email,
        )),
    ));

    // Only wipe the birthdate if this was their only booking
    if (empty($other_bookings)) {
        global $wpdb;
        $table = $wpdb->prefix . 'kc_mailing_list';
        $wpdb->update(
            $table,
            array('birthdate' => null),
            array('email'     => $email),
            array('%s'),
            array('%s')
        );
    }
}
