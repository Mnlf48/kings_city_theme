<?php
if (!defined('ABSPATH')) exit;

function kc_get_email_template($content) {
    return '
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background: #fff; padding: 2rem; border-radius: 8px; border: 1px solid #e5e7eb;">
      <div style="border-bottom: 3px solid #bd451f; padding-bottom: 1rem; margin-bottom: 1.5rem;">
        <h2 style="color: #bd451f; margin: 0;">Kings City</h2>
      </div>
      ' . $content . '
      <p style="margin-top: 2rem; color: #6b7280; font-size: 0.9rem;">Best regards,<br/><strong>The Kings City Team</strong></p>
    </div>';
}

function kc_send_crm_email($to, $subject, $message) {
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, kc_get_email_template($message), $headers);
}

function kc_get_client_data($post_id) {
    return array(
        'first_name' => get_post_meta($post_id, 'kc_first_name', true),
        'email'      => get_post_meta($post_id, 'kc_email', true),
        'service'    => get_post_meta($post_id, 'kc_service', true),
        'token'      => get_post_meta($post_id, 'kc_secure_token', true),
    );
}

function kc_email_step1_rejected($post_id, $reason) {
    $client = kc_get_client_data($post_id);
    $subject = "Update on Your Kings City Application";
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Thank you for applying to Kings City. Unfortunately, we cannot proceed with your application at this time.</p>';
    if (!empty($reason)) {
        $message .= '<p><strong>Reason:</strong><br>' . nl2br(esc_html($reason)) . '</p>';
    }
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_step1_approved_offshoring($post_id) {
    $client = kc_get_client_data($post_id);
    $subject = "Your Application Has Been Approved!";
    $step2_url = site_url('/apply/step-2/?token=' . $client['token']);
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Great news! Your initial application for offshoring services has been approved.</p>';
    $message .= '<p>Please click the button below to provide us with more details about your requirements so we can prepare for our discovery call.</p>';
    $message .= '<p style="text-align: center;"><a href="' . esc_url($step2_url) . '" style="display:inline-block; background:#bd451f; color:#fff; padding:12px 30px; border-radius:6px; text-decoration:none; font-weight:600;">Complete Step 2 →</a></p>';
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_step1_approved_spaces($post_id) {
    $client = kc_get_client_data($post_id);
    $subject = "Your Spaces Application Has Been Approved!";
    $tour_url = site_url('/apply-spaces-tour/?token=' . $client['token']);
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Great news! Your application for a Kings City space has been approved.</p>';
    $message .= '<p>Please click the button below to book a tour of our facilities.</p>';
    $message .= '<p style="text-align: center;"><a href="' . esc_url($tour_url) . '" style="display:inline-block; background:#bd451f; color:#fff; padding:12px 30px; border-radius:6px; text-decoration:none; font-weight:600;">Book a Tour →</a></p>';
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_step2_rejected($post_id, $reason) {
    $client = kc_get_client_data($post_id);
    $subject = "Update on Your Kings City Application";
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Thank you for submitting your detailed requirements. Unfortunately, after reviewing the details, we cannot proceed with your application at this time.</p>';
    if (!empty($reason)) {
        $message .= '<p><strong>Reason:</strong><br>' . nl2br(esc_html($reason)) . '</p>';
    }
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_step2_approved_offshoring($post_id) {
    $client = kc_get_client_data($post_id);
    $subject = "Step 2 Approved — Book Your Discovery Call";
    $step3_url = site_url('/apply/step-3/?token=' . $client['token']);
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Thank you for providing your detailed requirements. We have reviewed them and would like to invite you to a discovery call.</p>';
    $message .= '<p>Please click the button below to schedule a time that works for you.</p>';
    $message .= '<p style="text-align: center;"><a href="' . esc_url($step3_url) . '" style="display:inline-block; background:#bd451f; color:#fff; padding:12px 30px; border-radius:6px; text-decoration:none; font-weight:600;">Book Discovery Call →</a></p>';
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_step3_complete($post_id) {
    $client = kc_get_client_data($post_id);
    $subject = "Your Discovery Call is Confirmed!";
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Your discovery call is confirmed. We look forward to speaking with you!</p>';
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_tour_complete($post_id) {
    $client = kc_get_client_data($post_id);
    $subject = "Your Tour is Confirmed!";
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Your tour of Kings City is confirmed. We look forward to welcoming you!</p>';
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_booking_confirmed($post_id) {
    $client = kc_get_client_data($post_id);
    $subject = "Your Space Booking is Confirmed!";
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Your space booking payment has been received and your booking is now confirmed. See you soon!</p>';
    kc_send_crm_email($client['email'], $subject, $message);
}

function kc_email_booking_cancelled($post_id) {
    $client = kc_get_client_data($post_id);
    $subject = "Your Booking Has Been Cancelled";
    $message = '<p>Hi ' . esc_html($client['first_name']) . ',</p>';
    $message .= '<p>Your space booking has been cancelled. If you believe this is an error, please contact us.</p>';
    kc_send_crm_email($client['email'], $subject, $message);
}
