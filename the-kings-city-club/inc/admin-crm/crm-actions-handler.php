<?php
if (!defined('ABSPATH')) exit;

function kc_crm_handle_action($action_name, $callback) {
    add_action('admin_post_' . $action_name, function() use ($action_name, $callback) {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        
        if (!$post_id || !isset($_POST['kc_nonce']) || !wp_verify_nonce($_POST['kc_nonce'], 'kc_crm_action_' . $post_id)) {
            wp_die('Security check failed');
        }

        $reason = isset($_POST['reason']) ? sanitize_textarea_field($_POST['reason']) : '';

        try {
            $callback($post_id, $reason);
            $redirect_url = add_query_arg('message', 'success', wp_get_referer());
        } catch (Exception $e) {
            $redirect_url = add_query_arg('message', 'error', wp_get_referer());
        }

        wp_safe_redirect($redirect_url);
        exit;
    });
}

// kc_approve_step1
kc_crm_handle_action('kc_approve_step1', function($post_id, $reason) {
    $service = get_post_meta($post_id, 'kc_service', true);
    if (strpos($service, 'Spaces') !== false || strpos($service, 'Membership') !== false) {
        update_post_meta($post_id, 'kc_status', 'Step 2 - Waiting for Tour Booking');
        kc_email_step1_approved_spaces($post_id);
    } else {
        update_post_meta($post_id, 'kc_status', 'Step 2 - Waiting for Client Details');
        kc_email_step1_approved_offshoring($post_id);
    }
});

// kc_reject_step1
kc_crm_handle_action('kc_reject_step1', function($post_id, $reason) {
    update_post_meta($post_id, 'kc_status', 'Rejected');
    kc_email_step1_rejected($post_id, $reason);
});

// kc_approve_step2
kc_crm_handle_action('kc_approve_step2', function($post_id, $reason) {
    update_post_meta($post_id, 'kc_status', 'Step 3 - Discovery Call');
    kc_email_step2_approved_offshoring($post_id);
});

// kc_reject_step2
kc_crm_handle_action('kc_reject_step2', function($post_id, $reason) {
    update_post_meta($post_id, 'kc_status', 'Rejected');
    kc_email_step2_rejected($post_id, $reason);
});

// kc_mark_complete
kc_crm_handle_action('kc_mark_complete', function($post_id, $reason) {
    $service = get_post_meta($post_id, 'kc_service', true);
    if (strpos($service, 'Spaces') !== false || strpos($service, 'Membership') !== false) {
        update_post_meta($post_id, 'kc_status', 'Complete - Tour Scheduled');
        kc_email_tour_complete($post_id);
    } else {
        update_post_meta($post_id, 'kc_status', 'Complete');
        kc_email_step3_complete($post_id);
    }
});

// kc_confirm_booking
kc_crm_handle_action('kc_confirm_booking', function($post_id, $reason) {
    update_post_meta($post_id, 'kc_status', 'Paid / Claimed');
    kc_email_booking_confirmed($post_id);
});

// kc_cancel_booking
kc_crm_handle_action('kc_cancel_booking', function($post_id, $reason) {
    update_post_meta($post_id, 'kc_status', 'Expired / Cancelled');
    kc_email_booking_cancelled($post_id);
});
