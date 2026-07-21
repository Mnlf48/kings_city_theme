<?php
if (!defined('ABSPATH')) exit;

// Register custom roles on theme activation and keep capabilities in sync on every init
add_action('after_switch_theme', 'kc_register_user_roles');
add_action('init', 'kc_sync_user_roles');
function kc_sync_user_roles() {
    // Remove and re-add so DB capabilities always match code — safe, users keep their role assignment
    remove_role('kc_bookings_manager');
    remove_role('kc_content_editor');
    kc_register_user_roles();
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
        'edit_published_kc_bookings'=> true,
        'read_private_kc_bookings'  => true,
        'delete_kc_bookings'        => false,
        'delete_others_kc_bookings' => false,
        'publish_kc_bookings'       => true,

        // kg_quote_lead CPT + Newsletters + Email Templates (all use default post caps)
        'edit_posts'                => true,  // Required for inline status AJAX + add payment + continue pass
        'edit_others_posts'         => true,
        'edit_published_posts'      => true,
        'read_private_posts'        => true,
        'delete_posts'              => false,
        'delete_others_posts'       => false,
        'publish_posts'             => false,

        'manage_categories'         => true,  // Role Categories taxonomy submenu in Team Builder

        // Explicitly block everything else
        'edit_pages'                => false,
        'edit_others_pages'         => false,
        'publish_pages'             => false,
        'delete_pages'              => false,
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

    // --- kc_content_editor ---
    // Manages all site content: Pages (ACF), News, Space Add, Team Builder Roles, Newsletters, KPI Dashboard, Email Templates
    add_role('kc_content_editor', 'Content Editor', array(
        'read'                      => true,
        'upload_files'              => true,  // Media — swap images, upload assets

        // Pages — ACF content editing
        'edit_pages'                => true,
        'edit_others_pages'         => true,
        'edit_published_pages'      => true,
        'publish_pages'             => true,
        'read_private_pages'        => true,
        'delete_pages'              => false,

        // Posts — News & Insights + CPT access (Space Add, Team Builder, Newsletters)
        'edit_posts'                => true,
        'edit_others_posts'         => true,
        'edit_published_posts'      => true,
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

// Hide irrelevant menu items per role
add_action('admin_menu', 'kc_restrict_admin_menus', 999);
function kc_restrict_admin_menus() {
    $user = wp_get_current_user();
    if (!$user || empty($user->roles)) return;

    if (in_array('kc_bookings_manager', $user->roles)) {
        remove_menu_page('edit.php');                                                              // News & Insights (Posts)
        remove_menu_page('edit-comments.php');                                                     // Comments
        remove_menu_page('edit.php?post_type=kc_space');                                           // Space Add
        // Newsletters, Email Templates, and Team Builder (all submenus) remain visible
    }

    if (in_array('kc_content_editor', $user->roles)) {
        remove_menu_page('edit-comments.php');                          // Comments
        remove_menu_page('edit.php?post_type=kg_quote_lead');           // Quote Requests
        remove_menu_page('edit.php?post_type=kc_welcome_packet');       // Newsletters
    }
}

// Redirect custom roles to standard WP dashboard on login
// Bypasses GoDaddy's custom admin.php?page=wp-dashboard which requires manage_options
add_filter('login_redirect', 'kc_custom_role_login_redirect', 10, 3);
function kc_custom_role_login_redirect($redirect_to, $request, $user) {
    if (!isset($user->roles) || !is_array($user->roles)) return $redirect_to;
    if (in_array('kc_content_editor', $user->roles) || in_array('kc_bookings_manager', $user->roles)) {
        return admin_url('index.php');
    }
    return $redirect_to;
}

// Remove custom roles on theme switch/deactivation
add_action('switch_theme', 'kc_remove_user_roles');
function kc_remove_user_roles() {
    remove_role('kc_bookings_manager');
    remove_role('kc_content_editor');
}
