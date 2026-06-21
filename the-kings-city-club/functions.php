<?php
/**
 * Kings City Theme functions and definitions
 *
 * @package KingsCity
 */

if ( ! defined( 'KINGS_CITY_VERSION' ) ) {
	define( 'KINGS_CITY_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function kings_city_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'kingscity' ),
			'footer' => esc_html__( 'Footer Menu', 'kingscity' ),
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'kings_city_setup' );

/**
 * Enqueue scripts and styles.
 */
function kings_city_scripts() {
	// Enqueue combined style.css with aggressive cache busting
	wp_enqueue_style( 'kings-city-style', get_stylesheet_uri(), array(), time() );

	// Enqueue Google Fonts (from original header)
	wp_enqueue_style( 'kings-city-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@400;600;700&display=swap', array(), null );

    // Enqueue FontAwesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

	// Scripts
	wp_enqueue_script( 'kings-city-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), KINGS_CITY_VERSION, true );
	wp_enqueue_script( 'kings-city-main', get_template_directory_uri() . '/assets/js/main.js', array(), KINGS_CITY_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'kings_city_scripts' );

// Include ACF Fields
require_once get_template_directory() . '/inc/acf-fields.php';

/* =========================================================================
   Auto-Bootstrap Theme Pages on Activation
   ========================================================================= */
function kings_city_auto_populate_pages() {
    $pages = array(
        'Home' => 'front-page.php',
        'About' => 'page-about.php',
        'Spaces' => 'page-spaces.php',
        'Offshoring' => 'page-offshoring.php',
        'Our Brands' => 'page-our-brands.php',
        'Impact' => 'page-impact.php',
        'News & Insights' => 'page-news.php',
        'Apply Now' => 'page-apply.php',
        'Book a Tour' => 'page-book-now.php',
        'Step 2 Discovery' => 'page-apply-step-2.php'
    );

    $home_page_id = 0;

    foreach ( $pages as $page_title => $page_template ) {
        $page_check = get_page_by_title( $page_title );
        
        $new_page = array(
            'post_type' => 'page',
            'post_title' => $page_title,
            'post_content' => 'Content for ' . $page_title . ' goes here. Edit this in the WordPress admin.',
            'post_status' => 'publish',
            'post_author' => 1,
        );

        if ( ! isset( $page_check->ID ) ) {
            $new_page_id = wp_insert_post( $new_page );
            if ( ! is_wp_error( $new_page_id ) ) {
                update_post_meta( $new_page_id, '_wp_page_template', $page_template );
                if ( $page_title === 'Home' ) {
                    $home_page_id = $new_page_id;
                }
            }
        } else {
            // Ensure the template is set even if the page already exists
            update_post_meta( $page_check->ID, '_wp_page_template', $page_template );
            if ( $page_title === 'Home' ) {
                $home_page_id = $page_check->ID;
            }
        }
    }

    // Set Front Page
    if ( $home_page_id > 0 ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $home_page_id );
    }
}
add_action( 'after_switch_theme', 'kings_city_auto_populate_pages' );

/* =========================================================================
   Register Custom Post Types & Taxonomies
   ========================================================================= */
function kings_city_register_cpts() {
    // 1. Team Builder Roles
    register_post_type('tb_role', array(
        'labels' => array(
            'name' => 'Team Builder Roles',
            'singular_name' => 'Role',
            'add_new' => 'Add New Role',
            'add_new_item' => 'Add New Role',
            'edit_item' => 'Edit Role',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'editor'), // title = Role Name, editor = Description
    ));

    // 2. Staff Leasing Tiers
    register_post_type('sl_tier', array(
        'labels' => array(
            'name' => 'Staff Leasing Tiers',
            'singular_name' => 'Tier',
            'add_new' => 'Add New Tier',
            'add_new_item' => 'Add New Tier',
            'edit_item' => 'Edit Tier',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-clipboard',
        'supports' => array('title'), // title = Tier Name
    ));

    // 3. Staff Leasing Department Taxonomy
    register_taxonomy('sl_department', array('sl_tier'), array(
        'labels' => array(
            'name' => 'Departments',
            'singular_name' => 'Department',
            'add_new_item' => 'Add New Department',
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
    ));
}
add_action('init', 'kings_city_register_cpts');


// Load Kings City CRM System
require_once get_template_directory() . '/inc/admin-crm/init.php';
