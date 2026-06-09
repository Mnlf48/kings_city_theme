<?php
if (!defined('ABSPATH')) exit;

// Handler for Step 3 Discovery Call booking
function kc_calendly_step3_booked() {
    check_ajax_referer('kc_calendly_nonce', 'nonce');

    $token = isset($_POST['token']) ? sanitize_text_field($_POST['token']) : '';
    if (empty($token)) {
        wp_send_json_error(array('message' => 'Missing token'));
    }

    $args = array(
        'post_type'      => 'kc_application',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'     => 'kc_secure_token',
                'value'   => $token,
                'compare' => '='
            )
        )
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        $post_id = $posts[0]->ID;
        $current_status = get_post_meta($post_id, 'kc_status', true);

        if ($current_status === 'Step 3 - Discovery Call') {
            update_post_meta($post_id, 'kc_status', 'Step 3 - Submitted');
            wp_send_json_success(array('message' => 'Status updated successfully'));
        } else {
            wp_send_json_error(array('message' => 'Invalid status transition'));
        }
    } else {
        wp_send_json_error(array('message' => 'Application not found'));
    }

    wp_die();
}
add_action('wp_ajax_nopriv_kc_calendly_step3_booked', 'kc_calendly_step3_booked');
add_action('wp_ajax_kc_calendly_step3_booked', 'kc_calendly_step3_booked');

// Handler for Tour booking (Spaces)
function kc_calendly_tour_booked() {
    check_ajax_referer('kc_calendly_nonce', 'nonce');

    $token = isset($_POST['token']) ? sanitize_text_field($_POST['token']) : '';
    if (empty($token)) {
        wp_send_json_error(array('message' => 'Missing token'));
    }

    $args = array(
        'post_type'      => 'kc_application',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'     => 'kc_secure_token',
                'value'   => $token,
                'compare' => '='
            )
        )
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        $post_id = $posts[0]->ID;
        $current_status = get_post_meta($post_id, 'kc_status', true);

        if ($current_status === 'Step 2 - Waiting for Tour Booking') {
            update_post_meta($post_id, 'kc_status', 'Step 2 - Tour Submitted');
            wp_send_json_success(array('message' => 'Status updated successfully'));
        } else {
            wp_send_json_error(array('message' => 'Invalid status transition'));
        }
    } else {
        wp_send_json_error(array('message' => 'Application not found'));
    }

    wp_die();
}
add_action('wp_ajax_nopriv_kc_calendly_tour_booked', 'kc_calendly_tour_booked');
add_action('wp_ajax_kc_calendly_tour_booked', 'kc_calendly_tour_booked');
