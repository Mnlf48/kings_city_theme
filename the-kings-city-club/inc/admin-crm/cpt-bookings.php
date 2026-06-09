<?php
if (!defined('ABSPATH')) exit;

function kc_register_booking_cpt() {
    $labels = array(
        'name'                  => 'Bookings',
        'singular_name'         => 'Booking',
        'menu_name'             => 'Daily Bookings CRM',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Booking',
        'edit_item'             => 'View/Edit Booking',
        'all_items'             => 'All Bookings',
        'search_items'          => 'Search Bookings',
    );
    $args = array(
        'label'                 => 'Booking',
        'labels'                => $labels,
        'supports'              => array('title'),
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => false,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-calendar-alt',
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    );
    register_post_type('kc_booking', $args);
}
add_action('init', 'kc_register_booking_cpt');
