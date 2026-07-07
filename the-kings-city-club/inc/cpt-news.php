<?php
if (!defined('ABSPATH')) exit;

/**
 * Rename the default 'Posts' menu to 'News & Insights'
 */
function kc_rename_posts_to_news() {
    global $menu;
    global $submenu;
    
    // Rename Menu
    foreach ($menu as $key => $value) {
        if ($value[0] === 'Posts') {
            $menu[$key][0] = 'News & Insights';
            $menu[$key][6] = 'dashicons-admin-post'; // Maintain post icon
        }
    }
    
    // Rename Submenus
    if (isset($submenu['edit.php'])) {
        foreach ($submenu['edit.php'] as $key => $value) {
            if ($value[0] === 'All Posts' || $value[0] === 'Posts') {
                $submenu['edit.php'][$key][0] = 'All News & Insights';
            }
            if ($value[0] === 'Add New' || $value[0] === 'Add New Post') {
                $submenu['edit.php'][$key][0] = 'Add New Article';
            }
        }
    }
}
add_action('admin_menu', 'kc_rename_posts_to_news');

function kc_rename_posts_labels( $labels ) {
    $labels->name = 'News & Insights';
    $labels->singular_name = 'News Article';
    $labels->add_new = 'Add New';
    $labels->add_new_item = 'Add New Article';
    $labels->edit_item = 'Edit Article';
    $labels->new_item = 'New Article';
    $labels->view_item = 'View Article';
    $labels->view_items = 'View Articles';
    $labels->search_items = 'Search News & Insights';
    $labels->not_found = 'No articles found.';
    $labels->not_found_in_trash = 'No articles found in Trash.';
    $labels->all_items = 'All News & Insights';
    $labels->archives = 'News Archives';
    $labels->attributes = 'News Attributes';
    $labels->insert_into_item = 'Insert into article';
    $labels->uploaded_to_this_item = 'Uploaded to this article';
    $labels->featured_image = 'Featured Image / Card Image';
    $labels->set_featured_image = 'Set card image';
    $labels->remove_featured_image = 'Remove card image';
    $labels->use_featured_image = 'Use as card image';
    $labels->menu_name = 'News & Insights';
    $labels->name_admin_bar = 'News Article';
    return $labels;
}
add_filter( 'post_type_labels_post', 'kc_rename_posts_labels' );
