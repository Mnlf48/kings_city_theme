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
            echo "<strong>" . esc_html("$fname $lname") . "</strong><br>";
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
            $color = '#888';
            if ($status === 'Pending') $color = '#f59e0b';
            if ($status === 'Contacted') $color = '#3b82f6';
            if ($status === 'Completed') $color = '#10b981';
            if ($status === 'Rejected' || $status === 'Cancelled') $color = '#ef4444';
            echo "<span style='background: {$color}; color: white; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 11px;'>{$status}</span>";
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

// --- Meta Boxes ---

function kc_add_booking_meta_boxes() {
    add_meta_box(
        'kc_booking_details',
        'Booking Details & CRM',
        'kc_render_booking_details_meta_box',
        'kc_booking',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kc_add_booking_meta_boxes');

function kc_render_booking_details_meta_box($post) {
    wp_nonce_field('kc_save_booking_data', 'kc_booking_nonce');

    $fname = get_post_meta($post->ID, 'kc_first_name', true);
    $lname = get_post_meta($post->ID, 'kc_last_name', true);
    $email = get_post_meta($post->ID, 'kc_email', true);
    $phone = get_post_meta($post->ID, 'kc_phone', true);
    $space = get_post_meta($post->ID, 'kc_space_type', true);
    $duration = get_post_meta($post->ID, 'kc_duration', true);
    $price = get_post_meta($post->ID, 'kc_price', true);
    $start_date = get_post_meta($post->ID, 'kc_start_date', true);
    $arrival = get_post_meta($post->ID, 'kc_arrival_time', true);
    $participants = get_post_meta($post->ID, 'kc_participants', true);
    $special = get_post_meta($post->ID, 'kc_special', true);
    
    $status = get_post_meta($post->ID, 'kc_status', true);
    if (!$status) $status = 'Pending';

    $admin_note = get_post_meta($post->ID, 'kc_admin_note', true);

    ?>
    <table class="form-table">
        <tr>
            <th>Client Info</th>
            <td>
                <strong>Name:</strong> <?php echo esc_html("$fname $lname"); ?><br>
                <strong>Email:</strong> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><br>
                <strong>Phone:</strong> <?php echo esc_html($phone); ?>
            </td>
        </tr>
        <tr>
            <th>Booking Info</th>
            <td>
                <strong>Space:</strong> <?php echo esc_html($space); ?><br>
                <strong>Duration:</strong> <?php echo esc_html($duration); ?><br>
                <strong>Date:</strong> <?php echo esc_html($start_date); ?><br>
                <strong>Arrival Time:</strong> <?php echo esc_html($arrival); ?><br>
                <strong>Participants:</strong> <?php echo esc_html($participants); ?><br>
                <strong>Price:</strong> <?php echo esc_html($price); ?>
            </td>
        </tr>
        <tr>
            <th>Special Requests</th>
            <td><?php echo nl2br(esc_html($special)); ?></td>
        </tr>
        <tr>
            <th><label for="kc_status">Update Status</label></th>
            <td>
                <select name="kc_status" id="kc_status">
                    <option value="Pending" <?php selected($status, 'Pending'); ?>>Pending (Default)</option>
                    <option value="Contacted" <?php selected($status, 'Contacted'); ?>>Contacted (Sends Confirmation Email)</option>
                    <option value="Completed" <?php selected($status, 'Completed'); ?>>Completed / Paid (Starts Membership if applicable)</option>
                    <option value="Rejected" <?php selected($status, 'Rejected'); ?>>Rejected (Sends Rejection Email)</option>
                    <option value="Cancelled" <?php selected($status, 'Cancelled'); ?>>Cancelled (Frees up slot)</option>
                </select>
                <p class="description">Changing status to Contacted or Rejected will automatically send an email to the client.</p>
            </td>
        </tr>
        <tr>
            <th><label for="kc_admin_note">Admin Note (Rejection Reason)</label></th>
            <td>
                <textarea name="kc_admin_note" id="kc_admin_note" rows="3" style="width:100%;"><?php echo esc_textarea($admin_note); ?></textarea>
                <p class="description">If rejecting the booking, type the reason here. It will be included in the email.</p>
            </td>
        </tr>
    </table>
    <?php
}

// --- Save Logic & Automations ---

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
                // It's a monthly duration
                $expiry = date('Y-m-d', strtotime('+1 month'));
                update_post_meta($post_id, 'kc_membership_status', 'Active');
                update_post_meta($post_id, 'kc_membership_expiry', $expiry);
            } elseif (stripos($duration, 'Year') !== false || stripos($duration, 'Annual') !== false) {
                // It's an annual duration
                $expiry = date('Y-m-d', strtotime('+1 year'));
                update_post_meta($post_id, 'kc_membership_status', 'Active');
                update_post_meta($post_id, 'kc_membership_expiry', $expiry);
            } else {
                // Just a day pass or weekly pass
                update_post_meta($post_id, 'kc_membership_status', 'N/A');
            }
        }
    }
}
add_action('save_post_kc_booking', 'kc_save_booking_meta');
