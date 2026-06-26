<?php
if (!defined('ABSPATH')) exit;

function kc_register_cpt_news() {
    $labels = array(
        'name'               => 'News & Insights',
        'singular_name'      => 'News Article',
        'menu_name'          => 'News & Insights',
        'name_admin_bar'     => 'News Article',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New News Article',
        'new_item'           => 'New News Article',
        'edit_item'          => 'Edit News Article',
        'view_item'          => 'View News Article',
        'all_items'          => 'All News & Insights',
        'search_items'       => 'Search News & Insights',
        'not_found'          => 'No news found.',
        'not_found_in_trash' => 'No news found in Trash.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-admin-post',
        'query_var'          => true,
        'rewrite'            => array('slug' => 'news'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'supports'           => array('title'),
        'show_in_rest'       => false, // Disabled Gutenberg to force Classic Editor
    );

    register_post_type('kc_news', $args);
}
add_action('init', 'kc_register_cpt_news');



// Add custom column for thumbnail in admin list
function kc_set_custom_edit_kc_news_columns($columns) {
    $new_columns = array();
    foreach($columns as $key => $title) {
        if ($key === 'title') {
            $new_columns['kc_news_thumb'] = 'Cover Image';
        }
        $new_columns[$key] = $title;
    }
    return $new_columns;
}
add_filter('manage_kc_news_posts_columns', 'kc_set_custom_edit_kc_news_columns');

function kc_custom_kc_news_column($column, $post_id) {
    if ($column === 'kc_news_thumb') {
        $image_id = get_field('news_card_image', $post_id);
        if ($image_id) {
            echo wp_get_attachment_image($image_id, array(60, 60), false, array('style' => 'border-radius:4px; object-fit:cover;'));
        } else {
            echo '<div style="width:60px; height:60px; background:#e2e8f0; border-radius:4px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#64748b;">No Image</div>';
        }
    }
}
add_action('manage_kc_news_posts_custom_column', 'kc_custom_kc_news_column', 10, 2);

// Register ACF fields for News Architecture
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
	'key' => 'group_news_architecture',
	'title' => 'News Article Builder',
	'fields' => array(
        // Tab 1: The Card
		array(
			'key' => 'field_news_tab_card',
			'label' => 'Step 1: The Preview Card',
			'name' => '',
			'type' => 'tab',
			'instructions' => 'This is the information that will appear on the main News & Insights page.',
			'placement' => 'top',
		),
		array(
			'key' => 'field_news_card_image',
			'label' => 'Card Image',
			'name' => 'news_card_image',
			'type' => 'image',
			'return_format' => 'id',
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_news_card_excerpt',
			'label' => 'Short Excerpt',
			'name' => 'news_card_excerpt',
			'type' => 'textarea',
			'instructions' => 'A short 1-2 sentence summary for the front card.',
            'rows' => 3,
		),
        // Tab 2: The Article
		array(
			'key' => 'field_news_tab_article',
			'label' => 'Step 2: The Full Article',
			'name' => '',
			'type' => 'tab',
			'instructions' => 'This is the full article visitors see when they click Read More.',
			'placement' => 'top',
		),
		array(
			'key' => 'field_news_article_content',
			'label' => 'Article Content',
			'name' => 'news_article_content',
			'type' => 'wysiwyg',
			'media_upload' => 1,
            'tabs' => 'all',
            'toolbar' => 'full',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'kc_news',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
		1 => 'excerpt',
        2 => 'featured_image',
	),
	'active' => true,
));
endif;
