<?php
if (!defined('ABSPATH')) exit;

function kc_crm_register_menus() {
    add_menu_page(
        'Kings City CRM',
        'Kings City CRM',
        'manage_options',
        'kc-crm-dashboard',
        'kc_render_dashboard_page',
        'dashicons-building',
        3
    );

    add_submenu_page(
        'kc-crm-dashboard',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'kc-crm-dashboard',
        'kc_render_dashboard_page'
    );

    add_submenu_page(
        'kc-crm-dashboard',
        'Offshoring',
        'Offshoring',
        'manage_options',
        'kc-crm-offshoring',
        'kc_render_offshoring_page'
    );

    add_submenu_page(
        'kc-crm-dashboard',
        'Spaces Membership',
        'Spaces Membership',
        'manage_options',
        'kc-crm-spaces',
        'kc_render_spaces_page'
    );

    add_submenu_page(
        'kc-crm-dashboard',
        'Book a Space',
        'Book a Space',
        'manage_options',
        'kc-crm-bookings',
        'kc_render_bookings_page'
    );
}
add_action('admin_menu', 'kc_crm_register_menus');

function kc_crm_enqueue_admin_styles($hook) {
    if (strpos($hook, 'kc-crm') !== false) {
        wp_enqueue_style('kc-main-theme-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'));
    }
}
add_action('admin_enqueue_scripts', 'kc_crm_enqueue_admin_styles');
