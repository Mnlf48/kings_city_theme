<?php
if (!defined('ABSPATH')) exit;

function kc_register_cpt_welcome_packet() {
    $labels = array(
        'name'               => 'Newsletters',
        'singular_name'      => 'Newsletter',
        'menu_name'          => 'Newsletters',
        'name_admin_bar'     => 'Newsletter',
        'add_new'            => 'Add New Newsletter',
        'add_new_item'       => 'Add New Newsletter',
        'new_item'           => 'New Newsletter',
        'edit_item'          => 'Edit Newsletter',
        'view_item'          => 'View Newsletter',
        'all_items'          => 'All Newsletters',
        'search_items'       => 'Search Newsletters',
        'not_found'          => 'No newsletters found.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 30,
        'menu_icon'          => 'dashicons-email-alt',
        'supports'           => array('title'), // Title is the Newsletter Name
    );

    register_post_type('kc_welcome_packet', $args);
}
add_action('init', 'kc_register_cpt_welcome_packet');

// ACF Setup for Newsletters
if( function_exists('acf_add_local_field_group') ):

    // 1. URL and Active Toggle Fields for the Newsletter CPT
    acf_add_local_field_group(array(
        'key' => 'group_welcome_packet_details',
        'title' => 'Newsletter Details',
        'fields' => array(
            array(
                'key' => 'field_welcome_packet_url',
                'label' => 'Canva URL (or external link)',
                'name' => 'kc_packet_url',
                'type' => 'url',
                'instructions' => 'Paste the link to the Canva presentation or document here.',
                'required' => 1,
            ),
            array(
                'key' => 'field_welcome_packet_active',
                'label' => 'Newsletter Status',
                'name' => 'kc_is_active',
                'type' => 'select',
                'instructions' => 'Set to Active if you want this newsletter to be automatically emailed to newly confirmed bookings.',
                'choices' => array(
                    '1' => 'Active',
                    '0' => 'Inactive',
                ),
                'default_value' => '0',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'kc_welcome_packet',
                ),
            ),
        ),
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
    ));

endif;

// Add Custom Columns to Newsletters Admin View
add_filter('manage_kc_welcome_packet_posts_columns', 'kc_set_newsletter_columns');
function kc_set_newsletter_columns($columns) {
    $columns['kc_active_status'] = 'Status';
    return $columns;
}

add_action('manage_kc_welcome_packet_posts_custom_column', 'kc_custom_newsletter_column', 10, 2);
function kc_custom_newsletter_column($column, $post_id) {
    if ($column == 'kc_active_status') {
        $is_active = get_post_meta($post_id, 'kc_is_active', true);
        
        $bg = '#e5e7eb'; $color = '#4b5563'; // Inactive
        if ($is_active == '1') { $bg = '#BD451F'; $color = '#ffffff'; } // Active
        
        echo "<select class='kc-inline-newsletter-status' data-post-id='{$post_id}' style='background-color: {$bg}; color: {$color}; border: 1px solid {$color}; font-weight: 600; font-size:12px; padding:2px 24px 2px 8px; height:auto; min-height:26px; border-radius:4px;'>";
        
        $options = ['1' => 'Active', '0' => 'Inactive'];
        foreach ($options as $val => $label) {
            echo "<option value='{$val}' style='background-color:#fff; color:#000;' " . selected($is_active, $val, false) . ">{$label}</option>";
        }
        echo "</select>";
    }
}

// Inline AJAX Status Update for Newsletters
add_action('admin_footer', 'kc_newsletter_inline_status_script');
function kc_newsletter_inline_status_script() {
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'kc_welcome_packet') return;
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('.kc-inline-newsletter-status').on('change', function() {
            var select = $(this);
            var post_id = select.data('post-id');
            var new_status = select.val();
            
            if (new_status == '1') {
                select.css({'background-color': '#BD451F', 'color': '#ffffff', 'border-color': '#ffffff'});
            } else {
                select.css({'background-color': '#e5e7eb', 'color': '#4b5563', 'border-color': '#4b5563'});
            }
            
            $.post(ajaxurl, {
                action: 'kc_update_newsletter_status',
                post_id: post_id,
                status: new_status,
                nonce: '<?php echo wp_create_nonce("kc_newsletter_nonce"); ?>'
            }, function(response) {
                if(!response.success) {
                    alert('Error updating newsletter status.');
                }
            });
        });
    });
    </script>
    <?php
}

add_action('wp_ajax_kc_update_newsletter_status', 'kc_update_newsletter_status');
function kc_update_newsletter_status() {
    check_ajax_referer('kc_newsletter_nonce', 'nonce');
    if (!current_user_can('edit_posts')) wp_send_json_error();
    
    $post_id = intval($_POST['post_id']);
    $status = sanitize_text_field($_POST['status']);
    
    if (in_array($status, ['0', '1'])) {
        update_post_meta($post_id, 'kc_is_active', $status);
        wp_send_json_success();
    }
    wp_send_json_error();
}

