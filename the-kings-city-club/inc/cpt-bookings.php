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
        'capabilities'       => array(
            'create_posts' => 'do_not_allow', // Prevents manually creating bookings from admin easily
        ),
        'map_meta_cap'       => true,
    );

    register_post_type('kc_booking', $args);
}
add_action('init', 'kc_register_cpt_bookings');

// --- Custom Columns ---

function kc_set_custom_edit_kc_booking_columns($columns) {
    unset($columns['date']); // Remove default date
    $columns['client_info'] = 'Client Name';
    $columns['space_info'] = 'Space & Date';
    $columns['status'] = 'Status';
    $columns['membership'] = 'Membership';
    $columns['date'] = 'Submitted';
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
            if ($status === 'Completed') { $bg = '#bbf7d0'; $color = '#166534'; }
            if ($status === 'Rejected' || $status === 'Cancelled') { $bg = '#fecaca'; $color = '#991b1b'; }
            
            echo "<select class='kc-inline-status-select' data-post-id='{$post_id}' data-post-type='kc_booking' style='background-color: {$bg}; color: {$color}; border: 1px solid {$color}; font-weight: 600; font-size:12px; padding:2px 24px 2px 8px; height:auto; min-height:26px; border-radius:4px;'>";
            $options = ['Pending', 'Contacted', 'Completed', 'Rejected', 'Cancelled'];
            foreach ($options as $opt) {
                echo "<option value='{$opt}' style='background-color:#fff; color:#000;' " . selected($status, $opt, false) . ">{$opt}</option>";
            }
            echo "</select>";
            echo "<span class='kc-inline-status-spinner spinner' id='kc-spinner-{$post_id}' style='float:none; margin:0 0 0 5px;'></span>";
            break;
        case 'membership':
            $mem_status = get_post_meta($post_id, 'kc_membership_status', true);
            $mem_expiry = get_post_meta($post_id, 'kc_membership_expiry', true);
            if ($mem_status === 'Active') {
                echo "<span style='color: #d97706; font-weight: bold;'>👑 Active Member</span><br>";
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
    add_meta_box('kc_booking_status', 'Booking Status & Actions', 'kc_render_status_meta_box', 'kc_booking', 'side', 'high');
    add_meta_box('kc_booking_membership', 'Membership Tracker', 'kc_render_membership_meta_box', 'kc_booking', 'side', 'core');
    add_meta_box('kc_booking_notes', 'Internal Admin Notes', 'kc_render_notes_meta_box', 'kc_booking', 'side', 'core');
}
add_action('add_meta_boxes', 'kc_add_booking_meta_boxes');

// 1. Client Info Panel
function kc_render_client_meta_box($post) {
    $fname = get_post_meta($post->ID, 'kc_first_name', true);
    $lname = get_post_meta($post->ID, 'kc_last_name', true);
    $email = get_post_meta($post->ID, 'kc_email', true);
    $phone = get_post_meta($post->ID, 'kc_phone', true);
    ?>
    <div class="kc-panel-grid">
        <div class="kc-panel-field">
            <span class="kc-panel-label">Full Name</span>
            <span class="kc-panel-value"><span class="dashicons dashicons-admin-users" style="color:#94a3b8; font-size:16px; margin-right:5px; margin-top:2px;"></span> <?php echo esc_html("$fname $lname"); ?></span>
        </div>
        <div class="kc-panel-field">
            <span class="kc-panel-label">Phone Number</span>
            <span class="kc-panel-value"><span class="dashicons dashicons-phone" style="color:#94a3b8; font-size:16px; margin-right:5px; margin-top:2px;"></span> <?php echo esc_html($phone); ?></span>
        </div>
        <div class="kc-panel-field" style="grid-column: span 2;">
            <span class="kc-panel-label">Email Address</span>
            <span class="kc-panel-value"><span class="dashicons dashicons-email-alt" style="color:#94a3b8; font-size:16px; margin-right:5px; margin-top:2px;"></span> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span>
        </div>
    </div>
    <?php
}

// 2. Booking Specs Panel
function kc_render_specs_meta_box($post) {
    $space = get_post_meta($post->ID, 'kc_space_type', true);
    $duration = get_post_meta($post->ID, 'kc_duration', true);
    $price = get_post_meta($post->ID, 'kc_price', true);
    $start_date = get_post_meta($post->ID, 'kc_start_date', true);
    $arrival = get_post_meta($post->ID, 'kc_arrival_time', true);
    $participants = get_post_meta($post->ID, 'kc_participants', true);
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
        <div class="kc-panel-field kc-financial-highlight">
            <span class="kc-panel-label" style="color:#b58d3d;">Total Revenue (Amount Due)</span>
            <span class="kc-panel-value"><?php echo esc_html($price); ?></span>
        </div>
    </div>
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
        <option value="Pending" <?php selected($status, 'Pending'); ?>>⏳ Pending</option>
        <option value="Contacted" <?php selected($status, 'Contacted'); ?>>✉️ Contacted / Confirmed</option>
        <option value="Completed" <?php selected($status, 'Completed'); ?>>✅ Completed / Paid</option>
        <option value="Rejected" <?php selected($status, 'Rejected'); ?>>❌ Rejected</option>
        <option value="Cancelled" <?php selected($status, 'Cancelled'); ?>>🚫 Cancelled</option>
    </select>
    <p class="kc-status-desc">
        <strong>Automations:</strong><br>
        • <em>Contacted</em> instantly emails a confirmation to the client.<br>
        • <em>Completed</em> logs the revenue in the KPI dashboard and activates memberships.<br>
        • <em>Rejected</em> emails the client your admin notes below.
    </p>
    <?php
}

// 5. Membership Panel (Right)
function kc_render_membership_meta_box($post) {
    $mem_status = get_post_meta($post->ID, 'kc_membership_status', true);
    $mem_expiry = get_post_meta($post->ID, 'kc_membership_expiry', true);
    
    if ($mem_status === 'Active') {
        echo '<div class="kc-membership-badge kc-badge-active">👑 Active Member</div>';
        echo '<div style="font-size:13px; color:#475569; margin-top:5px;">Valid until: <strong>' . esc_html($mem_expiry) . '</strong></div>';
    } elseif ($mem_status === 'Expired') {
        echo '<div class="kc-membership-badge kc-badge-expired">Expired Member</div>';
        echo '<div style="font-size:13px; color:#475569; margin-top:5px;">Expired on: ' . esc_html($mem_expiry) . '</div>';
    } else {
        echo '<div style="font-size:13px; color:#64748b; font-style:italic;">This booking does not include a monthly/annual membership, or the booking is not yet completed.</div>';
    }
}

// 6. Admin Notes Panel (Right)
function kc_render_notes_meta_box($post) {
    $admin_note = get_post_meta($post->ID, 'kc_admin_note', true);
    ?>
    <textarea name="kc_admin_note" class="kc-admin-note-area" placeholder="Type rejection reasons or internal staff notes here..."><?php echo esc_textarea($admin_note); ?></textarea>
    <p class="kc-status-desc" style="margin-bottom:0;">These notes are only visible to admins. If you reject the booking, this exact text will be emailed to the client as the reason.</p>
    <?php
}


// --- Save Logic & Automations ---

function kc_process_booking_status_change($post_id, $new_status, $old_status) {
    if ($old_status === $new_status) return;

    update_post_meta($post_id, 'kc_status', $new_status);
    
    $email = get_post_meta($post_id, 'kc_email', true);
    $fname = get_post_meta($post_id, 'kc_first_name', true);
    $space = get_post_meta($post_id, 'kc_space_type', true);
    $date = get_post_meta($post_id, 'kc_start_date', true);
    $duration = get_post_meta($post_id, 'kc_duration', true);
    $note = get_post_meta($post_id, 'kc_admin_note', true);

    // 1. Email Logic
    if ($new_status === 'Contacted') {
        $subject = "Your Kings City Booking is Confirmed!";
        $message = "Hi $fname,\n\nYour booking for the $space on $date has been confirmed.\n\nPlease arrive on your chosen date and complete your payment at our front desk.\n\nSee you soon,\nThe Kings City Team";
        wp_mail($email, $subject, $message);
    } elseif ($new_status === 'Rejected') {
        $subject = "Update regarding your Kings City Booking";
        $message = "Hi $fname,\n\nUnfortunately, we are unable to accommodate your booking request for the $space on $date.\n\nReason:\n$note\n\nIf you have any questions, please reply to this email.\n\nThank you,\nThe Kings City Team";
        wp_mail($email, $subject, $message);
    }

    // 2. Membership Expiration Logic
    if ($new_status === 'Completed') {
        if (stripos($duration, 'Month') !== false) {
            $expiry = date('Y-m-d', strtotime('+1 month'));
            update_post_meta($post_id, 'kc_membership_status', 'Active');
            update_post_meta($post_id, 'kc_membership_expiry', $expiry);
        } elseif (stripos($duration, 'Year') !== false || stripos($duration, 'Annual') !== false) {
            $expiry = date('Y-m-d', strtotime('+1 year'));
            update_post_meta($post_id, 'kc_membership_status', 'Active');
            update_post_meta($post_id, 'kc_membership_expiry', $expiry);
        } else {
            update_post_meta($post_id, 'kc_membership_status', 'N/A');
        }
    }
}

function kc_save_booking_meta($post_id) {
    if (!isset($_POST['kc_booking_nonce']) || !wp_verify_nonce($_POST['kc_booking_nonce'], 'kc_save_booking_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $old_status = get_post_meta($post_id, 'kc_status', true);
    $new_status = sanitize_text_field($_POST['kc_status']);
    
    if (isset($_POST['kc_admin_note'])) {
        update_post_meta($post_id, 'kc_admin_note', sanitize_textarea_field($_POST['kc_admin_note']));
    }

    if ($old_status !== $new_status) {
        kc_process_booking_status_change($post_id, $new_status, $old_status);
    }
}
add_action('save_post_kc_booking', 'kc_save_booking_meta');
