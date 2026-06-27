<?php
if (!defined('ABSPATH')) exit;

function kc_register_cpt_welcome_packet() {
    $labels = array(
        'name'               => 'Welcome Packets',
        'singular_name'      => 'Welcome Packet',
        'menu_name'          => 'Welcome Packets',
        'name_admin_bar'     => 'Welcome Packet',
        'add_new'            => 'Add New Packet',
        'add_new_item'       => 'Add New Welcome Packet',
        'new_item'           => 'New Welcome Packet',
        'edit_item'          => 'Edit Welcome Packet',
        'view_item'          => 'View Welcome Packet',
        'all_items'          => 'All Packets',
        'search_items'       => 'Search Welcome Packets',
        'not_found'          => 'No welcome packets found.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 30,
        'menu_icon'          => 'dashicons-email-alt',
        'supports'           => array('title'), // Title is the Packet Name
    );

    register_post_type('kc_welcome_packet', $args);
}
add_action('init', 'kc_register_cpt_welcome_packet');

// ACF Setup for Welcome Packets
if( function_exists('acf_add_local_field_group') ):

    // 1. URL Field for the Welcome Packet CPT
    acf_add_local_field_group(array(
        'key' => 'group_welcome_packet_details',
        'title' => 'Packet Details',
        'fields' => array(
            array(
                'key' => 'field_welcome_packet_url',
                'label' => 'Canva URL (or external link)',
                'name' => 'kc_packet_url',
                'type' => 'url',
                'instructions' => 'Paste the link to the Canva presentation or document here.',
                'required' => 1,
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

    // 2. Options Page for Automation Settings
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page(array(
            'page_title'    => 'Automation Settings',
            'menu_title'    => 'Automations',
            'menu_slug'     => 'kc-automation-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'icon_url'      => 'dashicons-admin-generic',
            'position'      => 31,
        ));
    }

    // 3. Post Object Field on Options Page to select Active Packet
    acf_add_local_field_group(array(
        'key' => 'group_automation_settings',
        'title' => 'Email Automation',
        'fields' => array(
            array(
                'key' => 'field_automation_message',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'message' => '<strong>Smart Welcome Packet System</strong><br>Select the current Welcome Packet below. When a booking changes to "Contacted", the system will automatically email this packet to the client, but <em>only if they haven\'t received it before</em>.',
            ),
            array(
                'key' => 'field_active_welcome_packet',
                'label' => 'Active Welcome Packet',
                'name' => 'kc_active_welcome_packet',
                'type' => 'post_object',
                'instructions' => 'Select which Welcome Packet should be sent to newly contacted clients.',
                'post_type' => array(
                    0 => 'kc_welcome_packet',
                ),
                'return_format' => 'id',
                'ui' => 1,
                'allow_null' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'kc-automation-settings',
                ),
            ),
        ),
    ));

endif;
