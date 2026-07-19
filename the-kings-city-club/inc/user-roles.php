<?php
if (!defined('ABSPATH')) exit;

// Register custom roles on theme activation (and seed them if not yet in the DB)
add_action('after_switch_theme', 'kc_register_user_roles');
add_action('init', 'kc_seed_user_roles_once');
function kc_seed_user_roles_once() {
    if (!get_role('kc_bookings_manager') || !get_role('kc_content_editor')) {
        kc_register_user_roles();
    }
}
function kc_register_user_roles() {

    // --- kc_bookings_manager ---
    // Manages Bookings and Quote Requests only
    add_role('kc_bookings_manager', 'Bookings Manager', array(
        'read'                      => true,
        'upload_files'              => true,  // Media — for payment proofs, documents

        // kc_booking CPT
        'edit_kc_bookings'          => true,
        'edit_others_kc_bookings'   => true,
        'read_private_kc_bookings'  => true,
        'delete_kc_bookings'        => false,
        'delete_others_kc_bookings' => false,
        'publish_kc_bookings'       => true,

        // kg_quote_lead CPT
        'edit_posts'                => true,  // Required for inline status AJAX + add payment + continue pass
        'edit_others_posts'         => true,
        'read_private_posts'        => true,
        'delete_posts'              => false,
        'delete_others_posts'       => false,
        'publish_posts'             => false,

        // Explicitly block everything else
        'edit_pages'                => false,
        'edit_others_pages'         => false,
        'publish_pages'             => false,
        'delete_pages'              => false,
        'manage_options'            => false,
        'manage_categories'         => false,
        'edit_theme_options'        => false,
        'install_plugins'           => false,
        'activate_plugins'          => false,
        'edit_plugins'              => false,
        'install_themes'            => false,
        'edit_themes'               => false,
        'edit_users'                => false,
        'create_users'              => false,
        'delete_users'              => false,
        'list_users'                => false,
    ));

    // --- kc_content_editor ---
    // Manages all site content: Pages (ACF), News, Space Add, Team Builder Roles, Newsletters, KPI Dashboard, Email Templates
    add_role('kc_content_editor', 'Content Editor', array(
        'read'                      => true,
        'upload_files'              => true,  // Media — swap images, upload assets

        // Pages — ACF content editing
        'edit_pages'                => true,
        'edit_others_pages'         => true,
        'publish_pages'             => true,
        'read_private_pages'        => true,
        'delete_pages'              => false,

        // Posts — News & Insights + CPT access (Space Add, Team Builder, Newsletters)
        'edit_posts'                => true,
        'edit_others_posts'         => true,
        'publish_posts'             => true,
        'read_private_posts'        => true,
        'delete_posts'              => false,
        'delete_others_posts'       => false,
        'manage_categories'         => true,

        // Explicitly block sensitive areas
        'edit_kc_bookings'          => false,
        'edit_others_kc_bookings'   => false,
        'manage_options'            => false,
        'edit_theme_options'        => false,
        'install_plugins'           => false,
        'activate_plugins'          => false,
        'edit_plugins'              => false,
        'install_themes'            => false,
        'edit_themes'               => false,
        'edit_users'                => false,
        'create_users'              => false,
        'delete_users'              => false,
        'list_users'                => false,
    ));
}

// Remove custom roles on theme switch/deactivation
add_action('switch_theme', 'kc_remove_user_roles');
function kc_remove_user_roles() {
    remove_role('kc_bookings_manager');
    remove_role('kc_content_editor');
}
