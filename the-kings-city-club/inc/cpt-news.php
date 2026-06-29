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
			'instructions' => 'Build your article content below. Upload a cover image, write your text, and add gallery images.',
			'placement' => 'top',
		),
		// Cover Image — full-width featured image at top of article
		array(
			'key' => 'field_news_cover_image',
			'label' => 'Cover Image',
			'name' => 'news_cover_image',
			'type' => 'image',
			'instructions' => 'Upload a full-width featured image that appears at the top of your article.',
			'return_format' => 'array',
			'preview_size' => 'medium',
		),
		// Article body text (WYSIWYG with media upload enabled for inline images)
		array(
			'key' => 'field_news_article_content',
			'label' => 'Article Content',
			'name' => 'news_article_content',
			'type' => 'wysiwyg',
			'instructions' => 'Write your article text here. Use the "Add Media" button to insert images or create a gallery inline.',
			'media_upload' => 1,
			'tabs' => 'all',
			'toolbar' => 'full',
		),
		// Dedicated full-width image field between text blocks
		array(
			'key' => 'field_news_article_image',
			'label' => 'Article Image',
			'name' => 'news_article_image',
			'type' => 'image',
			'instructions' => 'Upload an image to display full-width and centered between your article text blocks. Leave empty to skip.',
			'return_format' => 'array',
			'preview_size' => 'medium',
		),
		// Optional second text block that appears after the Article Image
		array(
			'key' => 'field_news_article_content_2',
			'label' => 'Article Content (Part 2)',
			'name' => 'news_article_content_2',
			'type' => 'wysiwyg',
			'instructions' => 'Optional. Add more text that will appear below the Article Image.',
			'media_upload' => 0,
			'tabs' => 'all',
			'toolbar' => 'full',
			'required' => 0,
		),
		// Gallery columns selector
		array(
			'key' => 'field_news_inline_gallery_cols',
			'label' => 'Inline Gallery — Columns',
			'name' => 'news_inline_gallery_cols',
			'type' => 'select',
			'instructions' => 'Choose how many columns to display the gallery images in. (e.g. 2 = 1×2 or 2×2, 3 = 1×3 or 3×2 etc.)',
			'choices' => array(
				'1' => '1 Column (full-width stacked)',
				'2' => '2 Columns',
				'3' => '3 Columns',
			),
			'default_value' => '3',
			'allow_null' => 0,
			'required' => 0,
		),
		// Inline gallery (multiple images, any count)
		array(
			'key' => 'field_news_inline_gallery',
			'label' => 'Inline Gallery — Images',
			'name' => 'news_inline_gallery',
			'type' => 'gallery',
			'instructions' => 'Upload images here. They will be displayed in the number of columns chosen above. Leave empty to skip.',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'insert' => 'append',
			'library' => 'all',
			'min' => 0,
			'max' => 0,
			'required' => 0,
		),
        // Tab 3: Gallery Grid
		array(
			'key' => 'field_news_tab_gallery',
			'label' => 'Step 3: Photo Gallery',
			'name' => '',
			'type' => 'tab',
			'instructions' => 'Upload up to 6 images for the photo gallery grid. Use the position option to place it before or after your article text.',
			'placement' => 'top',
		),
		// Gallery position toggle
		array(
			'key' => 'field_news_gallery_position',
			'label' => 'Gallery Position',
			'name' => 'news_gallery_position',
			'type' => 'radio',
			'instructions' => 'Choose where the gallery appears in the article.',
			'choices' => array(
				'after_text'  => 'After article text (default)',
				'before_text' => 'Before article text',
			),
			'default_value' => 'after_text',
			'layout' => 'horizontal',
			'required' => 0,
		),
		array(
			'key' => 'field_news_gallery_message',
			'label' => '',
			'name' => '',
			'type' => 'message',
			'message' => '<strong>Photo Gallery Grid</strong><br>Upload up to 6 images below. They will display in a 3-column × 2-row grid on desktop and a 2-column grid on mobile. Leave any slot empty to skip it.',
		),
		array(
			'key' => 'field_news_gallery_1',
			'label' => 'Gallery Image 1',
			'name' => 'news_gallery_1',
			'type' => 'image',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'wrapper' => array('width' => '33'),
		),
		array(
			'key' => 'field_news_gallery_2',
			'label' => 'Gallery Image 2',
			'name' => 'news_gallery_2',
			'type' => 'image',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'wrapper' => array('width' => '33'),
		),
		array(
			'key' => 'field_news_gallery_3',
			'label' => 'Gallery Image 3',
			'name' => 'news_gallery_3',
			'type' => 'image',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'wrapper' => array('width' => '33'),
		),
		array(
			'key' => 'field_news_gallery_4',
			'label' => 'Gallery Image 4',
			'name' => 'news_gallery_4',
			'type' => 'image',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'wrapper' => array('width' => '33'),
		),
		array(
			'key' => 'field_news_gallery_5',
			'label' => 'Gallery Image 5',
			'name' => 'news_gallery_5',
			'type' => 'image',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'wrapper' => array('width' => '33'),
		),
		array(
			'key' => 'field_news_gallery_6',
			'label' => 'Gallery Image 6',
			'name' => 'news_gallery_6',
			'type' => 'image',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'wrapper' => array('width' => '33'),
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
