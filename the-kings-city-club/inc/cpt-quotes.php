<?php
if (!defined('ABSPATH')) exit;

function kc_register_cpt_quote_leads() {
    $labels = array(
        'name'               => 'Quote Requests',
        'singular_name'      => 'Quote Request',
        'menu_name'          => 'Quote Requests',
        'name_admin_bar'     => 'Quote Request',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Quote Request',
        'new_item'           => 'New Quote Request',
        'edit_item'          => 'Edit Quote Request',
        'view_item'          => 'View Quote Request',
        'all_items'          => 'Quote Requests',
        'search_items'       => 'Search Quote Requests',
        'not_found'          => 'No quote requests found.',
        'not_found_in_trash' => 'No quote requests found in Trash.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-chart-line',
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'capabilities'       => array(
            'create_posts' => 'do_not_allow', 
        ),
        'map_meta_cap'       => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'supports'           => array('title'),
    );

    register_post_type('kg_quote_lead', $args);
}
add_action('init', 'kc_register_cpt_quote_leads');

// Custom Columns for Quote Requests
function kc_set_custom_edit_kg_quote_lead_columns($columns) {
    unset($columns['date']); // Remove date, add later
    unset($columns['title']); // Remove default title
    $columns['client_info'] = 'Client Name';
    $columns['email'] = 'Email';
    $columns['roles'] = 'Roles';
    $columns['est_monthly'] = 'Est. Monthly';
    $columns['lead_status'] = 'Status';
    $columns['date'] = 'Submitted';
    return $columns;
}
add_filter('manage_kg_quote_lead_posts_columns', 'kc_set_custom_edit_kg_quote_lead_columns');

function kc_custom_kg_quote_lead_column($column, $post_id) {
    switch ($column) {
        case 'client_info':
            $fname = get_post_meta($post_id, 'first_name', true);
            $lname = get_post_meta($post_id, 'last_name', true);
            $edit_link = get_edit_post_link($post_id);
            echo "<strong><a href='" . esc_url($edit_link) . "' class='row-title'>" . esc_html($fname . ' ' . $lname) . "</a></strong>";
            break;
        case 'email':
            $email = get_post_meta($post_id, 'email', true);
            echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            break;
        case 'roles':
            $team_json = get_post_meta($post_id, 'team_json', true);
            $team_data = json_decode($team_json, true);
            if (!empty($team_data) && is_array($team_data)) {
                $roles = array();
                foreach($team_data as $role) {
                    $roles[] = esc_html($role['title']) . ' &times;' . esc_html($role['headcount']);
                }
                echo implode('<br>', $roles);
            } else {
                echo 'No roles';
            }
            break;
        case 'est_monthly':
            $est = get_post_meta($post_id, 'total_est', true);
            echo '<strong>' . esc_html($est) . '</strong>';
            break;
        case 'lead_status':
            $status = get_post_meta($post_id, 'lead_status', true);
            if (!$status) $status = 'Pending';
            
            $bg = '#fef08a'; $color = '#854d0e'; // Pending
            if ($status === 'Contacted') { $bg = '#bfdbfe'; $color = '#1e3a8a'; }
            if ($status === 'Closed') { $bg = '#bbf7d0'; $color = '#166534'; }
            if ($status === 'Rejected') { $bg = '#fecaca'; $color = '#991b1b'; }
            
            echo "<select class='kc-inline-status-select' data-post-id='{$post_id}' data-post-type='kg_quote_lead' style='background-color: {$bg}; color: {$color}; border: 1px solid {$color}; font-weight: 600; font-size:12px; padding:2px 24px 2px 8px; height:auto; min-height:26px; border-radius:4px;'>";
            $options = ['Pending', 'Contacted', 'Closed', 'Rejected'];
            foreach ($options as $opt) {
                echo "<option value='{$opt}' style='background-color:#fff; color:#000;' " . selected($status, $opt, false) . ">{$opt}</option>";
            }
            echo "</select>";
            echo "<span class='kc-inline-status-spinner spinner' id='kc-spinner-{$post_id}' style='float:none; margin:0 0 0 5px;'></span>";
            break;
    }
}
add_action('manage_kg_quote_lead_posts_custom_column', 'kc_custom_kg_quote_lead_column', 10, 2);

// Meta Box for Status
function kc_add_quote_lead_meta_boxes() {
    add_meta_box('quote_lead_details', 'Quote Details', 'kc_quote_lead_details_html', 'kg_quote_lead', 'normal', 'high');
    add_meta_box('quote_lead_status', 'Lead Status', 'kc_quote_lead_status_html', 'kg_quote_lead', 'side', 'high');
}
add_action('add_meta_boxes', 'kc_add_quote_lead_meta_boxes');

function kc_quote_lead_details_html($post) {
    $fname = get_post_meta($post->ID, 'first_name', true);
    $mname = get_post_meta($post->ID, 'middle_name', true);
    $lname = get_post_meta($post->ID, 'last_name', true);
    $email = get_post_meta($post->ID, 'email', true);
    $phone = get_post_meta($post->ID, 'phone', true);
    $address = get_post_meta($post->ID, 'address', true);
    $total_est = get_post_meta($post->ID, 'total_est', true);
    $team_json = get_post_meta($post->ID, 'team_json', true);
    $team_data = json_decode($team_json, true);

    echo '<style>
        .kc-quote-details-wrapper { background: #FFF9EF; padding: 20px; border-radius: 8px; border: 1px solid rgba(189,69,31,0.2); font-family: "Outfit", Arial, sans-serif; }
        .kc-quote-details-wrapper table.form-table th { color: #AC201A; font-weight: 600; text-align: left; padding: 10px 10px 10px 0; }
        .kc-quote-details-wrapper table.form-table td { color: #2B2B2B; padding: 10px; }
        .kc-quote-details-wrapper h3 { margin-top: 2rem; border-bottom: 2px solid rgba(189,69,31,0.1); padding-bottom: 0.5rem; color: #BD451F; font-weight: 800; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
        .kc-quote-team-table { width: 100%; border: 1px solid rgba(189,69,31,0.2); border-collapse: collapse; margin-top: 15px; }
        .kc-quote-team-table th { background-color: #BD451F; color: #FFF9EF; padding: 12px 15px; text-align: left; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .kc-quote-team-table td { background-color: #ffffff; border-bottom: 1px solid rgba(189,69,31,0.1); padding: 12px 15px; color: #2B2B2B; }
        .kc-quote-team-table tr:nth-child(even) td { background-color: #FFF9EF; }
    </style>';

    echo '<div class="kc-quote-details-wrapper">';
    echo '<table class="form-table" style="margin-top: 0;">';
    echo '<tr><th style="width: 200px;">Client Name</th><td>' . esc_html(trim("$fname $mname $lname")) . '</td></tr>';
    echo '<tr><th>Email</th><td><a href="mailto:' . esc_attr($email) . '" style="color: #AC201A; text-decoration: none;">' . esc_html($email) . '</a></td></tr>';
    echo '<tr><th>Phone</th><td>' . esc_html($phone) . '</td></tr>';
    echo '<tr><th>Address</th><td>' . nl2br(esc_html($address)) . '</td></tr>';
    echo '<tr><th>Est. Monthly Total</th><td><strong style="color: #BD451F; font-size: 16px;">' . esc_html($total_est) . '</strong></td></tr>';
    echo '</table>';

    echo '<h3>Team Configuration</h3>';
    if (!empty($team_data) && is_array($team_data)) {
        echo '<table class="kc-quote-team-table">';
        echo '<thead><tr><th>Role</th><th>Level / Qty</th><th style="text-align:right;">Subtotal</th></tr></thead>';
        echo '<tbody>';
        foreach ($team_data as $role) {
            echo '<tr>';
            echo '<td><strong>' . esc_html($role['title']) . '</strong></td>';
            echo '<td>' . esc_html($role['level']) . ' &times; ' . esc_html($role['headcount']) . '</td>';
            echo '<td style="text-align:right; font-weight: bold; color: #BD451F;">' . esc_html($role['monthly']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p style="color: #646970; font-style: italic;">No team roles specified.</p>';
    }
    echo '</div>';
}

function kc_quote_lead_status_html($post) {
    $status = get_post_meta($post->ID, 'lead_status', true);
    if (!$status) $status = 'Pending';
    
    $options = array('Pending', 'Contacted', 'Closed', 'Rejected');
    
    wp_nonce_field('kc_save_quote_lead', 'kc_quote_lead_nonce');
    
    echo '<div style="background: #FFF9EF; padding: 15px; border-radius: 8px; border: 1px solid rgba(189,69,31,0.2); font-family: \'Outfit\', Arial, sans-serif;">';
    echo '<select name="lead_status" style="width:100%; border-color: rgba(189,69,31,0.3); color: #AC201A; font-weight: bold; padding: 5px;">';
    foreach ($options as $opt) {
        echo '<option value="' . esc_attr($opt) . '" ' . selected($status, $opt, false) . '>' . esc_html($opt) . '</option>';
    }
    echo '</select>';
    echo '<p class="description" style="color: #646970; font-style: italic; margin-top: 10px;">Changing to Contacted, Closed, or Rejected will trigger an automated email to the client based on your Email Templates.</p>';
    echo '</div>';
}

// Helper to send quote emails
function kc_send_quote_email($tab_key, $to_email, $post_id) {
    if (empty($to_email)) return;

    $fname = get_post_meta($post_id, 'first_name', true);
    $lname = get_post_meta($post_id, 'last_name', true);
    $client_name = trim("$fname $lname");
    $client_email = get_post_meta($post_id, 'email', true);

    $prefix = 'kc_' . $tab_key . '_';
    
    // Default fallbacks based on tab
    $def_subject = ''; $def_heading = ''; $def_body = ''; $def_banner = ''; $def_btn_text = ''; $def_btn_url = '';
    
    if ($tab_key === 'quote_contacted') {
        $def_subject = 'Proposal Request Acknowledgment - Kings City';
        $def_heading = 'Proposal Request Acknowledgment';
        $def_body = 'Thank you for considering Kings City as your trusted workforce solutions partner. We have successfully received your service configuration request, and our business development team is currently analyzing your specific role requirements to formulate a comprehensive and competitive proposal tailored to your needs. We are committed to providing you with top-tier talent and look forward to the possibility of collaborating with you.';
        $def_banner = 'A dedicated representative will contact you within one business day to present a detailed pricing breakdown, discuss your specific needs, and answer any preliminary questions you may have.';
        $def_btn_text = 'Visit Kings City';
        $def_btn_url = '{site_url}';
    } elseif ($tab_key === 'quote_confirmed') {
        $def_subject = 'Welcome to Kings City - Partnership Confirmed';
        $def_heading = 'Partnership Confirmed';
        $def_body = 'We are absolutely delighted to officially welcome you as a valued partner of Kings City. Your service proposal and team configuration have been marked as confirmed, and we are already initiating the next steps in our onboarding and talent acquisition process. Our team is dedicated to ensuring a seamless transition and delivering exceptional workforce solutions that drive your business forward. You will be introduced to your dedicated account manager shortly.';
        $def_banner = 'We look forward to a successful and long-lasting partnership. Your account manager will be in touch with you shortly to begin the onboarding process.';
        $def_btn_text = 'Visit Kings City';
        $def_btn_url = '{site_url}';
    } elseif ($tab_key === 'quote_rejected') {
        $def_subject = 'Update on your Kings City Quote Request';
        $def_heading = 'Proposal Update';
        $def_body = "Thank you for reaching out to Kings City and giving us the opportunity to review your workforce needs. After carefully analyzing your service configuration request, we unfortunately cannot fulfill your specific role requirements at this time, as they fall outside our current operational capacities or talent pool specialties.\n\nWe deeply appreciate your interest in partnering with us, and we will keep your company profile on hand should our service offerings expand to cover your specific needs in the future.";
        $def_banner = 'We wish you the very best in your search for a suitable workforce solutions partner.';
        $def_btn_text = 'Visit Kings City';
        $def_btn_url = '{site_url}';
    }

    $raw_subject = get_option($prefix . 'subject', $def_subject);
    $raw_heading = get_option($prefix . 'heading', $def_heading);
    $raw_body = get_option($prefix . 'body', $def_body);
    $raw_banner = get_option($prefix . 'banner', $def_banner);
    $raw_btn_text = get_option($prefix . 'btn_text', $def_btn_text);
    $raw_btn_url = get_option($prefix . 'btn_url', $def_btn_url);

    $search = array('{client_name}', '{client_email}', '{site_url}', '{fname}');
    $replace = array($client_name, $client_email, home_url(), $fname);

    $subject = str_replace($search, $replace, $raw_subject);
    $email_heading = str_replace($search, $replace, $raw_heading);
    $email_body = str_replace($search, $replace, $raw_body);
    $email_banner = str_replace($search, $replace, $raw_banner);
    $email_btn_text = str_replace($search, $replace, $raw_btn_text);
    $email_btn_url = str_replace($search, $replace, $raw_btn_url);

    // Prepare data for the template
    $first_name = $fname; // Fallback for template
    $team_json_string = get_post_meta($post_id, 'team_json', true);
    $team_data = json_decode($team_json_string, true);
    $total_est = get_post_meta($post_id, 'total_est', true);

    ob_start();
    $template_path = get_template_directory() . '/emails/email-quote-master.php';
    if (file_exists($template_path)) {
        include($template_path);
    } else {
        echo "<p>" . nl2br(esc_html($email_body)) . "</p>";
    }
    $message = ob_get_clean();

    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to_email, $subject, $message, $headers);
}

function kc_process_quote_status_change($post_id, $new_status, $old_status) {
    if ($old_status === $new_status) return;

    update_post_meta($post_id, 'lead_status', $new_status);
    
    // Trigger Emails
    $client_email = get_post_meta($post_id, 'email', true);
    
    if ($new_status === 'Contacted') {
        kc_send_quote_email('quote_contacted', $client_email, $post_id);
    } elseif ($new_status === 'Closed') {
        kc_send_quote_email('quote_confirmed', $client_email, $post_id);
    } elseif ($new_status === 'Rejected') {
        kc_send_quote_email('quote_rejected', $client_email, $post_id);
    }
}

function kc_save_quote_lead_meta($post_id) {
    if (!isset($_POST['kc_quote_lead_nonce']) || !wp_verify_nonce($_POST['kc_quote_lead_nonce'], 'kc_save_quote_lead')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['lead_status'])) {
        $old_status = get_post_meta($post_id, 'lead_status', true);
        $new_status = sanitize_text_field($_POST['lead_status']);
        
        if ($old_status !== $new_status) {
            kc_process_quote_status_change($post_id, $new_status, $old_status);
        }
    }
}
add_action('save_post_kg_quote_lead', 'kc_save_quote_lead_meta');

// --- AJAX Form Submission for Quotes ---
function kc_ajax_submit_quote() {
    // Check nonce
    if (!isset($_POST['quote_nonce']) || !wp_verify_nonce($_POST['quote_nonce'], 'quote_submission')) {
        wp_send_json_error(array('message' => 'Security check failed. Please try again.'));
    }
    
    // Check honeypot
    if (!empty($_POST['website_url_trap'])) {
        wp_send_json_error(array('message' => 'Spam detected.'));
    }

    $fname = sanitize_text_field($_POST['first_name']);
    $mname = sanitize_text_field($_POST['middle_name']);
    $lname = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $address = sanitize_textarea_field($_POST['address']);
    $team_json = stripslashes($_POST['team_json']);
    
    $team_data = json_decode($team_json, true);
    
    $team_data = json_decode($team_json, true);
    
    // Check for recent submissions from the same email
    $recent_leads = get_posts(array(
        'post_type'      => 'kg_quote_lead',
        'meta_key'       => 'email',
        'meta_value'     => $email,
        'date_query'     => array(
            array(
                'after' => '7 days ago'
            )
        ),
        'posts_per_page' => 1
    ));

    if (!empty($recent_leads)) {
        wp_send_json_error(array('message' => 'You have recently submitted a quote request from this email. Please allow up to 7 days before submitting another, or contact us directly.'));
    }
    
    $post_id = wp_insert_post(array(
        'post_title'   => $fname . ' ' . $lname . ' - ' . esc_html($_POST['total_est']),
        'post_type'    => 'kg_quote_lead',
        'post_status'  => 'publish'
    ));

    if (!is_wp_error($post_id)) {
        update_post_meta($post_id, 'first_name', $fname);
        update_post_meta($post_id, 'middle_name', $mname);
        update_post_meta($post_id, 'last_name', $lname);
        update_post_meta($post_id, 'email', $email);
        update_post_meta($post_id, 'phone', $phone);
        update_post_meta($post_id, 'address', $address);
        update_post_meta($post_id, 'team_json', $team_json);
        update_post_meta($post_id, 'currency_used', sanitize_text_field($_POST['currency_used']));
        update_post_meta($post_id, 'total_est', sanitize_text_field($_POST['total_est']));
        update_post_meta($post_id, 'lead_status', 'Pending');
        
        // Email notification disabled per user request
        
        wp_send_json_success(array('message' => 'Quote Request Received! Our team will review your requirements and get back to you shortly.'));
    } else {
        wp_send_json_error(array('message' => 'An error occurred while saving your request. Please try again.'));
    }
}
add_action('wp_ajax_submit_quote', 'kc_ajax_submit_quote');
add_action('wp_ajax_nopriv_submit_quote', 'kc_ajax_submit_quote');
