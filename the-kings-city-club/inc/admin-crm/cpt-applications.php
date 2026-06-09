<?php
if (!defined('ABSPATH')) exit;

function kc_register_application_cpt() {
    $labels = array(
        'name'                  => 'Applications',
        'singular_name'         => 'Application',
        'menu_name'             => 'Offshoring & Spaces CRM',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Application',
        'edit_item'             => 'View/Edit Application',
        'all_items'             => 'All Applications',
        'search_items'          => 'Search Applications',
    );
    $args = array(
        'label'                 => 'Application',
        'labels'                => $labels,
        'supports'              => array('title'), // no editor, we use custom metaboxes
        'public'                => false, // private backend system
        'show_ui'               => true,
        'show_in_menu'          => false,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-id',
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    );
    register_post_type('kc_application', $args);
}
add_action('init', 'kc_register_application_cpt');
