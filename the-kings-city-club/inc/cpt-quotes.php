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

    echo '<table class="form-table">';
    echo '<tr><th>Client Name</th><td>' . esc_html(trim("$fname $mname $lname")) . '</td></tr>';
    echo '<tr><th>Email</th><td><a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></td></tr>';
    echo '<tr><th>Phone</th><td>' . esc_html($phone) . '</td></tr>';
    echo '<tr><th>Address</th><td>' . nl2br(esc_html($address)) . '</td></tr>';
    echo '<tr><th>Est. Monthly Total</th><td><strong>' . esc_html($total_est) . '</strong></td></tr>';
    echo '</table>';

    echo '<h3 style="margin-top:2rem; border-bottom: 1px solid #ccc; padding-bottom: 0.5rem;">TEAM CONFIGURATION</h3>';
    if (!empty($team_data) && is_array($team_data)) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Role</th><th>Level / Qty</th><th>Subtotal</th></tr></thead>';
        echo '<tbody>';
        foreach ($team_data as $role) {
            echo '<tr>';
            echo '<td>' . esc_html($role['title']) . '</td>';
            echo '<td>' . esc_html($role['level']) . ' &times; ' . esc_html($role['headcount']) . '</td>';
            echo '<td>' . esc_html($role['monthly']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>No team roles specified.</p>';
    }
}

function kc_quote_lead_status_html($post) {
    $status = get_post_meta($post->ID, 'lead_status', true);
    if (!$status) $status = 'Pending';
    
    $options = array('Pending', 'Contacted', 'Closed', 'Rejected');
    
    wp_nonce_field('kc_save_quote_lead', 'kc_quote_lead_nonce');
    
    echo '<select name="lead_status" style="width:100%;">';
    foreach ($options as $opt) {
        echo '<option value="' . esc_attr($opt) . '" ' . selected($status, $opt, false) . '>' . esc_html($opt) . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Changing to Contacted or Rejected will trigger an automated email to the client.</p>';
}

function kc_process_quote_status_change($post_id, $new_status, $old_status) {
    if ($old_status === $new_status) return;

    update_post_meta($post_id, 'lead_status', $new_status);
    
    // Trigger Emails
    $email = get_post_meta($post_id, 'email', true);
    $fname = get_post_meta($post_id, 'first_name', true);
    
    if ($new_status === 'Contacted' && !empty($email)) {
        $subject = "Your Kings City Quote Request - Let's Talk!";
        $message = "Hi $fname,\n\nThank you for requesting a team builder quote with Kings City. We've reviewed your requirements and would love to set up a quick discovery call to discuss the details.\n\nPlease let us know what time works best for you, or book a time on our calendar: [Insert Calendar Link]\n\nBest regards,\nKings City Team";
        wp_mail($email, $subject, $message);
    }
    
    if ($new_status === 'Rejected' && !empty($email)) {
        $subject = "Update on your Kings City Quote Request";
        $message = "Hi $fname,\n\nThank you for reaching out to Kings City. After reviewing your team configuration request, we unfortunately cannot fulfill your specific role requirements at this time.\n\nWe appreciate your interest and wish you the best in your search.\n\nBest regards,\nKings City Team";
        wp_mail($email, $subject, $message);
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
