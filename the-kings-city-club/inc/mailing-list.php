<?php
if (!defined('ABSPATH')) exit;

// --- 1. Create DB table on theme activation ---
function kc_create_mailing_list_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'kc_mailing_list';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        email VARCHAR(191) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        subscribed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'kc_create_mailing_list_table');

// Run on every load so new installs catch up without re-activating
add_action('admin_init', 'kc_create_mailing_list_table');

// --- 2. AJAX: frontend form submission ---
add_action('wp_ajax_nopriv_kc_mailing_list_subscribe', 'kc_mailing_list_subscribe');
add_action('wp_ajax_kc_mailing_list_subscribe',        'kc_mailing_list_subscribe');
function kc_mailing_list_subscribe() {
    check_ajax_referer('kc_mailing_list_nonce', 'nonce');

    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kc_mailing_list';

    $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$table} WHERE email = %s", $email));
    if ($exists) {
        wp_send_json_error(array('message' => 'This email is already on our list.'));
    }

    $inserted = $wpdb->insert(
        $table,
        array(
            'email'           => $email,
            'status'          => 'pending',
            'subscribed_at'   => current_time('mysql'),
        ),
        array('%s', '%s', '%s')
    );

    if ($inserted) {
        wp_send_json_success(array('message' => "You're on the list! We'll keep you posted."));
    }

    wp_send_json_error(array('message' => 'Something went wrong. Please try again.'));
}

// --- 3. AJAX: admin inline status update ---
add_action('wp_ajax_kc_ml_update_status', 'kc_ml_update_status');
function kc_ml_update_status() {
    check_ajax_referer('kc_ml_admin_nonce', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error();

    global $wpdb;
    $table  = $wpdb->prefix . 'kc_mailing_list';
    $id     = intval($_POST['id']);
    $status = sanitize_text_field($_POST['status']);

    if (!in_array($status, array('pending', 'active', 'unsubscribed'), true)) {
        wp_send_json_error();
    }

    $wpdb->update($table, array('status' => $status), array('id' => $id), array('%s'), array('%d'));
    wp_send_json_success();
}

// --- 4. AJAX: admin delete subscriber ---
add_action('wp_ajax_kc_ml_delete', 'kc_ml_delete');
function kc_ml_delete() {
    check_ajax_referer('kc_ml_admin_nonce', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error();

    global $wpdb;
    $table = $wpdb->prefix . 'kc_mailing_list';
    $id    = intval($_POST['id']);

    $wpdb->delete($table, array('id' => $id), array('%d'));
    wp_send_json_success();
}

// --- 5. AJAX: activate all pending ---
add_action('wp_ajax_kc_ml_activate_all_pending', 'kc_ml_activate_all_pending');
function kc_ml_activate_all_pending() {
    check_ajax_referer('kc_ml_admin_nonce', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error();

    global $wpdb;
    $table = $wpdb->prefix . 'kc_mailing_list';
    $updated = $wpdb->update($table, array('status' => 'active'), array('status' => 'pending'), array('%s'), array('%s'));
    wp_send_json_success(array('updated' => (int) $updated));
}

// --- 5c. AJAX: send newsletter broadcast ---
add_action('wp_ajax_kc_ml_send_newsletter', 'kc_ml_send_newsletter');
function kc_ml_send_newsletter() {
    check_ajax_referer('kc_ml_admin_nonce', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error(array('message' => 'Unauthorized.'));


    global $wpdb;
    $table      = $wpdb->prefix . 'kc_mailing_list';
    $custom_url = esc_url_raw(wp_unslash($_POST['custom_url'] ?? ''));
    $recipients = sanitize_text_field($_POST['recipients'] ?? 'both');

    // Fetch recipients
    if ($recipients === 'specific') {
        $raw_list = sanitize_text_field(wp_unslash($_POST['specific_emails'] ?? ''));
        $emails   = array_values(array_unique(array_filter(
            array_map('sanitize_email', explode(',', $raw_list))
        )));
        if (empty($emails)) {
            wp_send_json_error(array('message' => 'No valid email addresses provided.'));
        }
    } elseif ($recipients === 'active') {
        $emails = $wpdb->get_col("SELECT email FROM {$table} WHERE status = 'active'");
    } else {
        $emails = $wpdb->get_col("SELECT email FROM {$table} WHERE status IN ('pending','active')");
    }

    if (empty($emails)) {
        wp_send_json_error(array('message' => 'No recipients found for the selected audience.'));
    }

    // Pull template from Email Templates settings
    $prefix  = 'kc_newsletter_broadcast_';
    $subject = get_option($prefix . 'subject', 'News & Updates from The Kings City Club');
    $heading = get_option($prefix . 'heading', 'Stay in the Loop');
    $body    = get_option($prefix . 'body',    '');
    $banner  = get_option($prefix . 'banner',  '');
    $btn_text = get_option($prefix . 'btn_text', 'Visit Kings City');
    $btn_url  = get_option($prefix . 'btn_url',  '{site_url}');

    // Replace tokens
    $link     = $custom_url ?: home_url('/');
    $body     = str_replace('{site_url}', esc_url($link), $body);
    $btn_url  = str_replace('{site_url}', esc_url($link), $btn_url);

    // Build HTML using the branded template file (same pattern as booking emails)
    $email_heading  = $heading;
    $email_body     = $body;
    $email_banner   = $banner;
    $email_btn_text = $btn_text;
    $email_btn_url  = $btn_url;

    ob_start();
    include get_template_directory() . '/emails/email-newsletter.php';
    $html = ob_get_clean();

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $sent       = 0;
    $failed     = 0;
    $last_error = '';

    // Capture the real error from WP Mail SMTP / PHPMailer
    $mail_error_handler = function( $wp_error ) use ( &$last_error ) {
        $last_error = $wp_error->get_error_message();
    };
    add_action( 'wp_mail_failed', $mail_error_handler );

    foreach ($emails as $email) {
        $result = wp_mail($email, $subject, $html, $headers);
        $result ? $sent++ : $failed++;
    }

    remove_action( 'wp_mail_failed', $mail_error_handler );

    if ( $sent === 0 && $failed > 0 ) {
        wp_send_json_error(array(
            'message' => 'wp_mail() failed for all recipients. Error: ' . ( $last_error ?: 'Unknown — check WP Mail SMTP → Email Log for details.' ),
        ));
    }

    wp_send_json_success(array(
        'sent'      => $sent,
        'failed'    => $failed,
        'total'     => count($emails),
        'error_msg' => $last_error,
    ));
}

// --- 5b. AJAX: admin export CSV ---
add_action('admin_post_kc_ml_export_csv', 'kc_ml_export_csv');
function kc_ml_export_csv() {
    if (!current_user_can('manage_options')) wp_die('Unauthorized');
    check_admin_referer('kc_ml_export_csv');

    global $wpdb;
    $table = $wpdb->prefix . 'kc_mailing_list';
    $rows  = $wpdb->get_results("SELECT email, status, subscribed_at FROM {$table} ORDER BY subscribed_at DESC", ARRAY_A);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="mailing-list-' . gmdate('Y-m-d') . '.csv"');

    $out = fopen('php://output', 'w');
    fputcsv($out, array('Email', 'Status', 'Date Subscribed'));
    foreach ($rows as $row) {
        fputcsv($out, $row);
    }
    fclose($out);
    exit;
}

// --- 6. Admin submenu under Newsletters ---
add_action('admin_menu', 'kc_ml_add_submenu');
function kc_ml_add_submenu() {
    add_submenu_page(
        'edit.php?post_type=kc_welcome_packet',
        'Mailing List',
        'Mailing List',
        'manage_options',
        'kc-mailing-list',
        'kc_ml_render_page'
    );
}

// --- 7. Admin page render ---
function kc_ml_render_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'kc_mailing_list';

    // Filter + Search
    $filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'all';
    $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

    $conditions = array();
    if ($filter !== 'all') {
        $conditions[] = $wpdb->prepare("status = %s", $filter);
    }
    if ($search !== '') {
        $conditions[] = $wpdb->prepare("email LIKE %s", '%' . $wpdb->esc_like($search) . '%');
    }
    $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
    $rows  = $wpdb->get_results("SELECT * FROM {$table} {$where} ORDER BY subscribed_at DESC");

    $counts = array(
        'all'          => (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}"),
        'pending'      => (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE status = 'pending'"),
        'active'       => (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE status = 'active'"),
        'unsubscribed' => (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE status = 'unsubscribed'"),
    );

    $export_url = wp_nonce_url(admin_url('admin-post.php?action=kc_ml_export_csv'), 'kc_ml_export_csv');
    $admin_nonce = wp_create_nonce('kc_ml_admin_nonce');

    $status_colors = array(
        'pending'      => array('bg' => '#FBCB77', 'color' => '#2B2B2B', 'arrow' => '%232B2B2B'),
        'active'       => array('bg' => '#BD451F', 'color' => '#ffffff', 'arrow' => '%23ffffff'),
        'unsubscribed' => array('bg' => '#e5e7eb', 'color' => '#4b5563', 'arrow' => '%234b5563'),
    );
    ?>
    <div class="wrap">
        <h1 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; display:flex; align-items:center; gap:10px;">
            <span class="dashicons dashicons-email-alt" style="font-size:28px; color:#BD451F;"></span>
            Mailing List
        </h1>

        <style>
            .kc-ml-stats { display:flex; gap:12px; margin:16px 0 20px; }
            .kc-ml-stat { background:#fff; border:1px solid #e5e7eb; border-radius:6px; padding:14px 20px; text-align:center; min-width:100px; }
            .kc-ml-stat .num { font-size:28px; font-weight:800; color:#BD451F; line-height:1; }
            .kc-ml-stat .lbl { font-size:11px; text-transform:uppercase; letter-spacing:.5px; color:#6b7280; margin-top:4px; }
            .kc-ml-filters { display:flex; gap:8px; margin-bottom:16px; }
            .kc-ml-filter-btn { padding:5px 14px; border-radius:20px; border:1px solid #d1d5db; background:#f9fafb; color:#374151; font-size:12px; font-weight:600; text-decoration:none; cursor:pointer; }
            .kc-ml-filter-btn.active { background:#BD451F; color:#fff; border-color:#BD451F; }
            .kc-ml-table { width:100%; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.08); }
            .kc-ml-table th { background:#BD451F; color:#fff; font-size:11px; text-transform:uppercase; letter-spacing:.5px; padding:10px 14px; text-align:left; }
            .kc-ml-table td { padding:10px 14px; border-bottom:1px solid #f3f4f6; font-size:13px; vertical-align:middle; }
            .kc-ml-table tr:last-child td { border-bottom:none; }
            .kc-ml-table tr:hover td { background:#fffaf7; }
            .kc-ml-select-wrap { position:relative; display:inline-block; overflow:hidden; border-radius:4px; min-width:130px; }
            .kc-ml-select-arrow { position:absolute; right:9px; top:50%; transform:translateY(-50%); pointer-events:none; font-size:10px; line-height:1; font-style:normal; }
            .kc-ml-status-select { font-weight:600; font-size:12px; padding:6px 28px 6px 10px; border:none; cursor:pointer; appearance:none; -webkit-appearance:none; -moz-appearance:none; width:calc(100% + 20px); background-image:none !important; }
            .kc-ml-delete-btn { background:#fff0f0; border:1px solid #ef4444; color:#ef4444; cursor:pointer; font-size:12px; font-weight:600; padding:6px 14px; border-radius:4px; min-width:90px; }
            .kc-ml-delete-btn:hover { background:#ef4444; color:#fff; border-color:#ef4444; }
            .kc-ml-export-btn { display:inline-flex; align-items:center; gap:6px; background:#FFF9EF; border:1px solid #BD451F; color:#BD451F; padding:7px 16px; border-radius:4px; font-weight:700; font-size:13px; text-decoration:none; }
            .kc-ml-export-btn:hover { background:#BD451F; color:#fff; }
            .kc-ml-toolbar { display:flex; align-items:center; gap:10px; margin-bottom:16px; flex-wrap:wrap; }
            .kc-ml-search-wrap { display:flex; gap:0; flex:1; max-width:360px; }
            .kc-ml-search-input { flex:1; border:1px solid #d1d5db; border-right:none; padding:7px 12px; font-size:13px; border-radius:4px 0 0 4px; outline:none; }
            .kc-ml-search-input:focus { border-color:#BD451F; }
            .kc-ml-search-btn { background:#BD451F; color:#fff; border:1px solid #BD451F; padding:7px 14px; font-size:13px; font-weight:700; cursor:pointer; border-radius:0 4px 4px 0; }
            .kc-ml-search-btn:hover { background:#8E1510; border-color:#8E1510; }
            .kc-ml-activate-btn { display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #BD451F; color:#BD451F; padding:7px 14px; border-radius:4px; font-weight:700; font-size:13px; cursor:pointer; }
            .kc-ml-activate-btn:hover { background:#BD451F; color:#fff; }
            .kc-ml-activate-btn:disabled { opacity:.5; cursor:not-allowed; }
            .kc-ml-send-btn { display:inline-flex; align-items:center; gap:6px; background:#AC201A; border:1px solid #AC201A; color:#FFF9EF; padding:7px 14px; border-radius:4px; font-weight:700; font-size:13px; cursor:pointer; }
            .kc-ml-send-btn:hover { background:#8E1510; border-color:#8E1510; color:#FFF9EF; }
            /* Modal */
            .kc-ml-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; }
            .kc-ml-modal-overlay.open { display:flex; }
            .kc-ml-modal { background:#fff; border-radius:8px; width:480px; max-width:95vw; box-shadow:0 8px 32px rgba(0,0,0,0.18); overflow:hidden; }
            .kc-ml-modal-header { background:#BD451F; padding:18px 24px; display:flex; align-items:center; justify-content:space-between; }
            .kc-ml-modal-header h2 { margin:0; color:#FFF9EF; font-size:16px; font-weight:800; }
            .kc-ml-modal-close { background:none; border:none; color:#FFF9EF; font-size:20px; cursor:pointer; line-height:1; padding:0; }
            .kc-ml-modal-body { padding:24px; }
            .kc-ml-modal-body label { display:block; font-weight:700; font-size:13px; color:#2B2B2B; margin-bottom:6px; margin-top:16px; }
            .kc-ml-modal-body label:first-child { margin-top:0; }
            .kc-ml-modal-body input[type=url] { width:100%; padding:8px 12px; border:1px solid #d1d5db; border-radius:4px; font-size:13px; box-sizing:border-box; }
            .kc-ml-modal-body input[type=url]:focus { border-color:#BD451F; outline:none; }
            .kc-ml-modal-body .kc-ml-radio-group { display:flex; flex-direction:column; gap:8px; margin-top:6px; }
            .kc-ml-modal-body .kc-ml-radio-group label { font-weight:400; display:flex; align-items:center; gap:8px; margin:0; cursor:pointer; }
            .kc-ml-modal-footer { padding:16px 24px; border-top:1px solid #f3f4f6; display:flex; justify-content:flex-end; gap:10px; }
            .kc-ml-modal-cancel { background:#f3f4f6; border:1px solid #d1d5db; color:#374151; padding:8px 18px; border-radius:4px; font-weight:600; font-size:13px; cursor:pointer; }
            .kc-ml-modal-confirm { background:#AC201A; border:1px solid #AC201A; color:#FFF9EF; padding:8px 18px; border-radius:4px; font-weight:700; font-size:13px; cursor:pointer; }
            .kc-ml-modal-confirm:hover { background:#8E1510; }
            .kc-ml-modal-confirm:disabled { opacity:.5; cursor:not-allowed; }
            .kc-ml-send-result { padding:12px 16px; border-radius:4px; font-size:13px; font-weight:600; margin-top:12px; display:none; }
            .kc-ml-send-result.success { background:#f0fdf4; border:1px solid #86efac; color:#166534; }
            .kc-ml-send-result.error   { background:#fff0f0; border:1px solid #fca5a5; color:#991b1b; }
            /* Tag input */
            .kc-ml-tag-input { display:flex; flex-wrap:wrap; gap:6px; padding:6px 8px; border:1px solid #d1d5db; border-radius:4px; cursor:text; min-height:40px; align-items:center; }
            .kc-ml-tag-input:focus-within { border-color:#BD451F; }
            .kc-ml-tag-input input { border:none; outline:none; font-size:13px; padding:2px 4px; flex:1; min-width:180px; background:transparent; }
            .kc-ml-tag { display:inline-flex; align-items:center; gap:4px; background:#BD451F; color:#fff; font-size:12px; font-weight:600; padding:3px 8px; border-radius:3px; }
            .kc-ml-tag-remove { background:none; border:none; color:#fff; cursor:pointer; font-size:14px; line-height:1; padding:0; opacity:.8; }
            .kc-ml-tag-remove:hover { opacity:1; }
        </style>

        <!-- Stats -->
        <div class="kc-ml-stats">
            <div class="kc-ml-stat"><div class="num" id="kc-ml-count-all"><?php echo esc_html($counts['all']); ?></div><div class="lbl">Total</div></div>
            <div class="kc-ml-stat"><div class="num" id="kc-ml-count-pending"><?php echo esc_html($counts['pending']); ?></div><div class="lbl">Pending</div></div>
            <div class="kc-ml-stat"><div class="num" id="kc-ml-count-active"><?php echo esc_html($counts['active']); ?></div><div class="lbl">Active</div></div>
            <div class="kc-ml-stat"><div class="num" id="kc-ml-count-unsubscribed"><?php echo esc_html($counts['unsubscribed']); ?></div><div class="lbl">Unsubscribed</div></div>
        </div>

        <!-- Toolbar: Search + Activate All + Export -->
        <div class="kc-ml-toolbar">
            <form method="get" class="kc-ml-search-wrap">
                <input type="hidden" name="post_type" value="kc_welcome_packet" />
                <input type="hidden" name="page" value="kc-mailing-list" />
                <input type="hidden" name="filter" value="<?php echo esc_attr($filter); ?>" />
                <input type="text" name="s" class="kc-ml-search-input" placeholder="Search by email…" value="<?php echo esc_attr($search); ?>" />
                <button type="submit" class="kc-ml-search-btn">
                    <span class="dashicons dashicons-search" style="font-size:15px; line-height:1.6;"></span>
                </button>
            </form>

            <button class="kc-ml-activate-btn" id="kc-ml-activate-all"
                    <?php echo ($counts['pending'] === 0) ? 'disabled' : ''; ?>>
                <span class="dashicons dashicons-yes-alt" style="font-size:16px; line-height:1.5;"></span>
                Activate All Pending (<?php echo esc_html($counts['pending']); ?>)
            </button>

            <button class="kc-ml-send-btn" id="kc-ml-open-send">
                <span class="dashicons dashicons-email-alt" style="font-size:16px; line-height:1.5;"></span> Send Newsletter
            </button>

            <a href="<?php echo esc_url($export_url); ?>" class="kc-ml-export-btn">
                <span class="dashicons dashicons-download" style="font-size:16px; line-height:1.4;"></span> Export CSV
            </a>
        </div>

        <!-- Send Newsletter Modal -->
        <div class="kc-ml-modal-overlay" id="kc-ml-send-modal">
            <div class="kc-ml-modal">
                <div class="kc-ml-modal-header">
                    <h2><span class="dashicons dashicons-email-alt" style="font-size:18px;vertical-align:middle;margin-right:6px;"></span> Send Newsletter</h2>
                    <button class="kc-ml-modal-close" id="kc-ml-close-modal">&times;</button>
                </div>
                <div class="kc-ml-modal-body">
                    <label for="kc-ml-custom-url">Custom Link URL <span style="font-weight:400;color:#6b7280;">(optional — replaces {site_url} token)</span></label>
                    <input type="url" id="kc-ml-custom-url" placeholder="https://example.com/your-article" />

                    <label>Send To</label>
                    <div class="kc-ml-radio-group">
                        <label>
                            <input type="radio" name="kc_ml_recipients" value="both" checked />
                            Pending + Active subscribers
                            <span style="color:#6b7280;font-size:12px;">(<?php echo esc_html($counts['pending'] + $counts['active']); ?> total)</span>
                        </label>
                        <label>
                            <input type="radio" name="kc_ml_recipients" value="active" />
                            Active only
                            <span style="color:#6b7280;font-size:12px;">(<?php echo esc_html($counts['active']); ?> total)</span>
                        </label>
                        <label>
                            <input type="radio" name="kc_ml_recipients" value="specific" />
                            Specific subscribers
                            <span style="color:#6b7280;font-size:12px;">(enter emails below)</span>
                        </label>
                    </div>

                    <!-- Specific email tag input — shown only when "specific" is selected -->
                    <div id="kc-ml-specific-wrap" style="display:none; margin-top:10px;">
                        <div class="kc-ml-tag-input" id="kc-ml-tag-box">
                            <input type="text" id="kc-ml-tag-entry" placeholder="Type an email and press Enter or comma…" autocomplete="off" />
                        </div>
                        <p style="font-size:11px; color:#6b7280; margin:4px 0 0;">Press <strong>Enter</strong> or <strong>,</strong> after each email. Click the × to remove.</p>
                    </div>

                    <div class="kc-ml-send-result" id="kc-ml-send-result"></div>
                </div>
                <div class="kc-ml-modal-footer">
                    <button class="kc-ml-modal-cancel" id="kc-ml-cancel-send">Cancel</button>
                    <button class="kc-ml-modal-confirm" id="kc-ml-confirm-send">
                        <span class="dashicons dashicons-email-alt" style="font-size:14px;vertical-align:middle;margin-right:4px;"></span> Send Now
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="kc-ml-filters">
            <?php foreach (array('all' => 'All', 'pending' => 'Pending', 'active' => 'Active', 'unsubscribed' => 'Unsubscribed') as $key => $label): ?>
                <a href="?post_type=kc_welcome_packet&page=kc-mailing-list&filter=<?php echo esc_attr($key); ?><?php echo $search ? '&s=' . urlencode($search) : ''; ?>"
                   class="kc-ml-filter-btn <?php echo ($filter === $key) ? 'active' : ''; ?>">
                    <?php echo esc_html($label); ?> (<?php echo esc_html($key === 'all' ? $counts['all'] : $counts[$key]); ?>)
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Table -->
        <?php if (empty($rows)): ?>
            <p style="color:#6b7280; font-style:italic;">No subscribers yet.</p>
        <?php else: ?>
        <table class="kc-ml-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Date Subscribed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $i => $row):
                    $sc = $status_colors[$row->status] ?? $status_colors['unsubscribed'];
                ?>
                <tr id="kc-ml-row-<?php echo esc_attr($row->id); ?>">
                    <td style="color:#9ca3af; font-size:11px;"><?php echo esc_html($i + 1); ?></td>
                    <td><strong><?php echo esc_html($row->email); ?></strong></td>
                    <td>
                        <div class="kc-ml-select-wrap">
                            <select class="kc-ml-status-select"
                                    data-id="<?php echo esc_attr($row->id); ?>"
                                    data-arrow="<?php echo esc_attr($sc['color']); ?>"
                                    style="background-color:<?php echo esc_attr($sc['bg']); ?>; color:<?php echo esc_attr($sc['color']); ?>;">
                                <?php foreach (array('pending' => 'Pending', 'active' => 'Active', 'unsubscribed' => 'Unsubscribed') as $val => $lbl): ?>
                                    <option value="<?php echo esc_attr($val); ?>" <?php selected($row->status, $val); ?>
                                            style="background:#fff; color:#000;">
                                        <?php echo esc_html($lbl); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="kc-ml-select-arrow" style="color:<?php echo esc_attr($sc['color']); ?>;">&#9660;</span>
                        </div>
                    </td>
                    <td style="color:#6b7280; font-size:12px;"><?php echo esc_html(date_i18n('M j, Y g:i a', strtotime($row->subscribed_at))); ?></td>
                    <td>
                        <button class="kc-ml-delete-btn" data-id="<?php echo esc_attr($row->id); ?>">&#x2715; Remove</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var nonce = '<?php echo esc_js($admin_nonce); ?>';
        var colors = {
            pending:      { bg: '#FBCB77', color: '#2B2B2B' },
            active:       { bg: '#BD451F', color: '#ffffff' },
            unsubscribed: { bg: '#e5e7eb', color: '#4b5563' }
        };

        // Helper: read a counter tile
        function getCount(key) { return parseInt($('#kc-ml-count-' + key).text()) || 0; }
        function setCount(key, val) { $('#kc-ml-count-' + key).text(Math.max(0, val)); }

        // Inline status change
        $('.kc-ml-status-select').on('change', function() {
            var sel       = $(this);
            var id        = sel.data('id');
            var oldStatus = sel.data('prev') || sel.find('option[selected]').val() || sel.data('orig');
            var newStatus = sel.val();
            var c         = colors[newStatus];
            sel.css({ 'background-color': c.bg, color: c.color });
            sel.siblings('.kc-ml-select-arrow').css('color', c.color);

            // Decrement old, increment new
            if (oldStatus && oldStatus !== newStatus) {
                setCount(oldStatus, getCount(oldStatus) - 1);
                setCount(newStatus, getCount(newStatus) + 1);
                // Update activate-all button count
                $('#kc-ml-activate-all').html(
                    '<span class="dashicons dashicons-yes-alt" style="font-size:16px;line-height:1.5;"></span> Activate All Pending (' + getCount('pending') + ')'
                ).prop('disabled', getCount('pending') === 0);
            }
            sel.data('prev', newStatus);

            $.post(ajaxurl, { action: 'kc_ml_update_status', id: id, status: newStatus, nonce: nonce }, function(r) {
                if (!r.success) alert('Error updating status.');
            });
        });

        // Store original status for each row so first change can diff correctly
        $('.kc-ml-status-select').each(function() {
            $(this).data('prev', $(this).val());
        });

        // Delete row
        $('.kc-ml-delete-btn').on('click', function() {
            var btn    = $(this);
            var id     = btn.data('id');
            var row    = $('#kc-ml-row-' + id);
            var status = row.find('.kc-ml-status-select').val();
            if (!confirm('Remove this subscriber?')) return;

            $.post(ajaxurl, { action: 'kc_ml_delete', id: id, nonce: nonce }, function(r) {
                if (r.success) {
                    setCount(status, getCount(status) - 1);
                    setCount('all',  getCount('all')  - 1);
                    row.fadeOut(300, function() { $(this).remove(); });
                } else {
                    alert('Error removing subscriber.');
                }
            });
        });

        // ----- Tag-input for specific emails -----
        var specificEmails = [];

        function renderTags() {
            $('#kc-ml-tag-box .kc-ml-tag').remove();
            var entry = $('#kc-ml-tag-entry');
            $.each(specificEmails, function(i, email) {
                var tag = $('<span class="kc-ml-tag"></span>').text(email);
                var rm  = $('<button class="kc-ml-tag-remove" type="button">&times;</button>');
                rm.on('click', function() {
                    specificEmails.splice(i, 1);
                    renderTags();
                });
                tag.append(rm);
                entry.before(tag);
            });
        }

        function addTag(raw) {
            var emails = raw.split(/[\s,]+/);
            $.each(emails, function(_, e) {
                e = e.trim().toLowerCase();
                if (e && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e) && specificEmails.indexOf(e) === -1) {
                    specificEmails.push(e);
                }
            });
            renderTags();
        }

        $('#kc-ml-tag-entry').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                var val = $(this).val().trim();
                if (val) { addTag(val); $(this).val(''); }
            } else if (e.key === 'Backspace' && $(this).val() === '' && specificEmails.length) {
                specificEmails.pop();
                renderTags();
            }
        }).on('blur', function() {
            var val = $(this).val().trim();
            if (val) { addTag(val); $(this).val(''); }
        });

        // Click anywhere in tag box focuses the input
        $('#kc-ml-tag-box').on('click', function() { $('#kc-ml-tag-entry').focus(); });

        // Show/hide specific panel on radio change
        $('input[name="kc_ml_recipients"]').on('change', function() {
            if ($(this).val() === 'specific') {
                $('#kc-ml-specific-wrap').show();
                $('#kc-ml-tag-entry').focus();
            } else {
                $('#kc-ml-specific-wrap').hide();
            }
        });

        // Send Newsletter modal
        $('#kc-ml-open-send').on('click', function() {
            $('#kc-ml-send-result').hide().removeClass('success error').text('');
            // Reset to "both" and hide specific panel each time modal opens
            $('input[name="kc_ml_recipients"][value="both"]').prop('checked', true);
            $('#kc-ml-specific-wrap').hide();
            specificEmails = [];
            renderTags();
            $('#kc-ml-send-modal').addClass('open');
        });
        $('#kc-ml-close-modal, #kc-ml-cancel-send').on('click', function() {
            $('#kc-ml-send-modal').removeClass('open');
        });
        $('#kc-ml-send-modal').on('click', function(e) {
            if ($(e.target).is('#kc-ml-send-modal')) $(this).removeClass('open');
        });

        $('#kc-ml-confirm-send').on('click', function() {
            var btn        = $(this);
            var custom_url = $('#kc-ml-custom-url').val().trim();
            var recipients = $('input[name="kc_ml_recipients"]:checked').val();
            var result     = $('#kc-ml-send-result');

            // Flush any partially-typed email in the tag box
            var pending = $('#kc-ml-tag-entry').val().trim();
            if (pending) { addTag(pending); $('#kc-ml-tag-entry').val(''); }

            if (recipients === 'specific' && specificEmails.length === 0) {
                result.removeClass('success').addClass('error')
                      .text('Please add at least one email address.').show();
                return;
            }

            btn.prop('disabled', true).html('<span class="dashicons dashicons-update" style="font-size:14px;vertical-align:middle;margin-right:4px;"></span> Sending…');
            result.hide().removeClass('success error');

            var payload = {
                action:     'kc_ml_send_newsletter',
                custom_url: custom_url,
                recipients: recipients,
                nonce:      nonce
            };
            if (recipients === 'specific') {
                payload.specific_emails = specificEmails.join(',');
            }

            $.post(ajaxurl, payload, function(r) {
                btn.prop('disabled', false).html('<span class="dashicons dashicons-email-alt" style="font-size:14px;vertical-align:middle;margin-right:4px;"></span> Send Now');
                if (r.success) {
                    var msg = '✓ Sent to ' + r.data.sent + ' of ' + r.data.total + ' recipients.';
                    if (r.data.failed > 0) msg += ' ' + r.data.failed + ' failed.';
                    if (r.data.error_msg) msg += ' Error: ' + r.data.error_msg;
                    var isPartialFail = r.data.failed > 0;
                    result.addClass(isPartialFail ? 'error' : 'success').text(msg).show();
                    if (!isPartialFail) {
                        setTimeout(function() {
                            $('#kc-ml-send-modal').removeClass('open');
                            $('#kc-ml-custom-url').val('');
                            result.hide().removeClass('success error').text('');
                        }, 2000);
                    }
                } else {
                    result.addClass('error').text('✗ ' + (r.data.message || 'Failed to send.')).show();
                }
            }).fail(function() {
                btn.prop('disabled', false).html('<span class="dashicons dashicons-email-alt" style="font-size:14px;vertical-align:middle;margin-right:4px;"></span> Send Now');
                result.addClass('error').text('✗ Request failed. Please try again.').show();
            });
        });

        // Activate all pending
        $('#kc-ml-activate-all').on('click', function() {
            var btn = $(this);
            if (!confirm('Activate all pending subscribers?')) return;

            btn.prop('disabled', true).text('Activating…');

            $.post(ajaxurl, { action: 'kc_ml_activate_all_pending', nonce: nonce }, function(r) {
                if (r.success) {
                    var pendingCount = getCount('pending');
                    // Update every pending row in the table immediately
                    $('.kc-ml-status-select').each(function() {
                        if ($(this).val() === 'pending') {
                            $(this).val('active').data('prev', 'active')
                                   .css({ 'background-color': colors.active.bg, color: colors.active.color });
                            $(this).siblings('.kc-ml-select-arrow').css('color', colors.active.color);
                        }
                    });
                    // Update the stat tiles
                    setCount('active', getCount('active') + pendingCount);
                    setCount('pending', 0);
                    btn.html('<span class="dashicons dashicons-yes-alt" style="font-size:16px;line-height:1.5;"></span> Activate All Pending (0)')
                       .prop('disabled', true);
                } else {
                    alert('Error activating subscribers.');
                    btn.prop('disabled', false)
                       .html('<span class="dashicons dashicons-yes-alt" style="font-size:16px;line-height:1.5;"></span> Activate All Pending (' + getCount('pending') + ')');
                }
            });
        });
    });
    </script>
    <?php
}
