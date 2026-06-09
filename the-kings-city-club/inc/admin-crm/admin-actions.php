<?php
if (!defined('ABSPATH')) exit;

/**
 * Renders a colored badge for the CRM status.
 */
function kc_render_status_badge($status) {
    $color = '#6b7280'; // Default gray
    $bg = '#f3f4f6';

    if ($status === 'Step 1 - Pending Approval') {
        $color = '#b45309'; // Yellow/Orange
        $bg = '#fef3c7';
    } elseif (strpos($status, 'Step 2') !== false || strpos($status, 'Step 3') !== false) {
        $color = '#1d4ed8'; // Blue
        $bg = '#dbeafe';
    } elseif (strpos($status, 'Complete') !== false || $status === 'Paid / Claimed') {
        $color = '#047857'; // Green
        $bg = '#d1fae5';
    } elseif ($status === 'Rejected' || strpos($status, 'Cancelled') !== false) {
        $color = '#b91c1c'; // Red
        $bg = '#fee2e2';
    } elseif ($status === 'Pending Payment') {
        $color = '#b45309'; // Yellow/Orange
        $bg = '#fef3c7';
    }

    echo '<span style="display:inline-block; padding:4px 8px; border-radius:12px; font-size:12px; font-weight:600; color:' . esc_attr($color) . '; background-color:' . esc_attr($bg) . ';">' . esc_html($status) . '</span>';
}

/**
 * Cron Job to expire old bookings (24 hours)
 */
if (!wp_next_scheduled('kc_daily_booking_cleanup')) {
    wp_schedule_event(time(), 'hourly', 'kc_daily_booking_cleanup');
}
add_action('kc_daily_booking_cleanup', 'kc_expire_old_bookings');

function kc_expire_old_bookings() {
    $args = array(
        'post_type'      => 'kc_booking',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'kc_status',
                'value'   => 'Pending Payment',
                'compare' => '='
            )
        )
    );

    $bookings = get_posts($args);
    $now = current_time('timestamp');

    foreach ($bookings as $booking) {
        $start_date = get_post_meta($booking->ID, 'kc_start_date', true);
        $arrival_time = get_post_meta($booking->ID, 'kc_arrival_time', true);

        if ($start_date && $arrival_time) {
            $booking_time_string = $start_date . ' ' . $arrival_time;
            $booking_timestamp = strtotime($booking_time_string);

            // If the booking start time was more than 24 hours ago
            if ($booking_timestamp && ($now - $booking_timestamp) > DAY_IN_SECONDS) {
                update_post_meta($booking->ID, 'kc_status', 'Expired / Cancelled');
                
                // Trigger cancellation email to client
                if (function_exists('kc_email_booking_cancelled')) {
                    kc_email_booking_cancelled($booking->ID);
                }
            }
        }
    }
}
