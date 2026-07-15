<?php
if (!defined('ABSPATH')) exit;
/**
 * Kings City Theme functions and definitions
 *
 * @package KingsCity
 */

if ( ! defined( 'KINGS_CITY_VERSION' ) ) {
	define( 'KINGS_CITY_VERSION', '1.0.0' );
}

/**
 * Splits a 3-word heading so words 1-2 are grouped with &nbsp; and word 3 wraps.
 * Falls back to the raw heading if it isn't exactly 3 words.
 * Echoes the result directly.
 */
function kc_split_heading( $heading ) {
	$h = esc_html( trim( $heading ) );
	if ( ! $h ) return;
	$w = explode( ' ', $h );
	if ( count( $w ) === 3 ) {
		echo $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2];
	} else {
		echo $h;
	}
}

/**
 * Returns the permalink for the first page using a given template file.
 * Falls back to home_url($fallback_path) if no page is found.
 */
function kc_get_page_url( $template_file, $fallback_path = '/' ) {
	$pages = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => $template_file,
		'number'     => 1,
	) );
	return ! empty( $pages ) ? esc_url( get_permalink( $pages[0]->ID ) ) : esc_url( home_url( $fallback_path ) );
}

/**
 * Non-deprecated replacement for get_page_by_title().
 * Returns the page ID or false if not found.
 */
function kc_get_page_id_by_title( $title, $post_type = 'page' ) {
	$pages = get_posts( array(
		'post_type'              => $post_type,
		'title'                  => $title,
		'post_status'            => 'any',
		'posts_per_page'         => 1,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	) );
	return ! empty( $pages ) ? $pages[0]->ID : false;
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

    // Enable HTML5 markup for galleries and captions
    add_theme_support('html5', array('gallery', 'caption'));
}
add_action( 'after_setup_theme', 'kings_city_setup' );

add_filter('rest_endpoints', function($endpoints) {
    if (!is_user_logged_in()) {
        unset($endpoints['/wp/v2/users']);
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});

add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
add_filter('style_loader_src', function($src) {
    return $src ? remove_query_arg('ver', $src) : $src;
});
add_filter('script_loader_src', function($src) {
    return $src ? remove_query_arg('ver', $src) : $src;
});

add_action('send_headers', function() {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    if (is_ssl()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
});

/**
 * Open Graph & Twitter Card meta tags for link previews.
 */
function kc_og_meta_tags() {
    $site_name    = 'The Kings City Club';
    $default_desc = 'A premium coworking and business community in Metro Manila. Flexible workspaces, private offices, meeting rooms, and more.';
    $fallback_img = get_template_directory_uri() . '/assets/img/front-page-img/kings-img31.webp';

    // --- Resolve image URL ---
    if ( is_singular( 'post' ) && has_post_thumbnail() ) {
        // Blog post: use featured image
        $img_url = esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) );
    } elseif ( is_front_page() ) {
        // Homepage: use hero slide 1 ACF field
        $hero = get_field( 'hero_section_img_1', get_the_ID() );
        $img_url = ( $hero && isset( $hero['url'] ) ) ? esc_url( $hero['url'] ) : esc_url( $fallback_img );
    } else {
        // All other pages: fall back to homepage hero image
        $img_url = esc_url( $fallback_img );
    }

    // --- Resolve title & description ---
    if ( is_front_page() ) {
        $title = esc_attr( $site_name . ' — Premium Coworking in Manila' );
        $desc  = esc_attr( $default_desc );
    } elseif ( is_singular() ) {
        $title = esc_attr( get_the_title() . ' — ' . $site_name );
        $desc  = has_excerpt() ? esc_attr( get_the_excerpt() ) : esc_attr( $default_desc );
    } else {
        $title = esc_attr( wp_title( '—', false, 'right' ) . $site_name );
        $desc  = esc_attr( $default_desc );
    }

    $url = esc_url( ( is_singular() ? get_permalink() : home_url( '/' ) ) );

    echo '<meta property="og:type"        content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:site_name"   content="' . esc_attr( $site_name ) . '">' . "\n";
    echo '<meta property="og:url"         content="' . $url . '">' . "\n";
    echo '<meta property="og:title"       content="' . $title . '">' . "\n";
    echo '<meta property="og:description" content="' . $desc . '">' . "\n";
    echo '<meta property="og:image"       content="' . $img_url . '">' . "\n";
    echo '<meta property="og:image:width" content="1200">' . "\n";
    echo '<meta property="og:image:height" content="630">' . "\n";
    echo '<meta name="twitter:card"       content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title"      content="' . $title . '">' . "\n";
    echo '<meta name="twitter:description" content="' . $desc . '">' . "\n";
    echo '<meta name="twitter:image"      content="' . $img_url . '">' . "\n";
}
add_action( 'wp_head', 'kc_og_meta_tags', 2 );

/**
 * Favicon — KC logo in browser tab, bookmarks, and home screen.
 */
function kc_favicon() {
    $base = get_template_directory_uri() . '/assets/img/favicon';
    echo '<link rel="icon" type="image/x-icon"     href="' . $base . '/favicon.ico">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="32x32"   href="' . $base . '/favicon-32x32.png">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="16x16"   href="' . $base . '/favicon-16x16.png">' . "\n";
    echo '<link rel="apple-touch-icon"      sizes="180x180" href="' . $base . '/favicon-180x180.png">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="192x192" href="' . $base . '/favicon-192x192.png">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="512x512" href="' . $base . '/favicon-512x512.png">' . "\n";
}
add_action( 'wp_head', 'kc_favicon', 1 );

/**
 * Enqueue scripts and styles.
 */
function kings_city_scripts() {
	// Enqueue combined style.css with aggressive cache busting
	wp_enqueue_style( 'kings-city-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );


	// Scripts
	wp_enqueue_script( 'kings-city-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), KINGS_CITY_VERSION, true );
	wp_enqueue_script( 'kings-city-hero-slider', get_template_directory_uri() . '/assets/js/hero-slider.js', array(), KINGS_CITY_VERSION, true );
	wp_enqueue_script( 'kings-city-gallery-carousel', get_template_directory_uri() . '/assets/js/gallery-carousel.js', array(), KINGS_CITY_VERSION, true );

	// Messenger float button styles
	$messenger_css = '
.kc-messenger-wrap {
	position: fixed;
	bottom: 24px;
	right: 24px;
	z-index: 9999;
	display: inline-block;
}
.kc-messenger-btn {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 56px;
	height: 56px;
	border-radius: 50%;
	background-color: #A03A1A;
	box-shadow: 0 4px 16px rgba(160, 58, 26, 0.45);
	transition: transform 0.3s ease-out, box-shadow 0.2s ease-out;
	text-decoration: none;
}
.kc-messenger-btn:hover,
.kc-messenger-btn:focus {
	background-color: #FBCB77;
	transform: translateY(-4px);
	box-shadow: 0 8px 24px rgba(251, 203, 119, 0.55);
	outline: none;
}
.kc-messenger-btn svg {
	width: 28px;
	height: 28px;
	fill: #FFF9EF;
	display: block;
}
.kc-messenger-close {
	position: absolute;
	top: -5px;
	right: -5px;
	width: 18px;
	height: 18px;
	border-radius: 50%;
	background: #AC201A;
	border: 2px solid #FFF9EF;
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 0;
	transition: background 0.2s ease-out;
}
.kc-messenger-close svg {
	width: 8px;
	height: 8px;
	display: block;
	fill: none;
	stroke: #FFF9EF;
	stroke-width: 2.5;
	stroke-linecap: round;
}
.kc-messenger-close:hover,
.kc-messenger-close:focus {
	background: #FBCB77;
	outline: none;
}
@media (prefers-reduced-motion: reduce) {
	.kc-messenger-btn,
	.kc-messenger-close {
		transition: none;
	}
	.kc-messenger-btn:hover,
	.kc-messenger-btn:focus {
		transform: none;
	}
}';
	wp_add_inline_style( 'kings-city-style', $messenger_css );

	// Page-specific: Apply Now (team builder)
	if ( is_page_template( 'page-apply.php' ) ) {
		wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
		wp_enqueue_script( 'kings-city-team-builder', get_template_directory_uri() . '/assets/js/team-builder.js', array(), KINGS_CITY_VERSION, true );

		$tb_roles_raw = array();
		$tb_query = new WP_Query( array( 'post_type' => 'tb_role', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
		if ( $tb_query->have_posts() ) {
			while ( $tb_query->have_posts() ) {
				$tb_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'tb_role_category' );
				$cat   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'Uncategorized';
				if ( ! isset( $tb_roles_raw[ $cat ] ) ) {
					$tb_roles_raw[ $cat ] = array( 'cat' => $cat, 'roles' => array() );
				}
				$tb_roles_raw[ $cat ]['roles'][] = array(
					'id'   => get_post_field( 'post_name', get_post() ),
					'name' => get_the_title(),
					'desc' => wp_strip_all_tags( get_the_content() ),
					'base' => (int) get_field( 'base_price' ),
				);
			}
			wp_reset_postdata();
		}

		$tb_currencies = get_option( 'kc_tb_currencies', array(
			array( 'code' => 'AUD', 'rate' => 0.026 ),
			array( 'code' => 'USD', 'rate' => 0.017 ),
			array( 'code' => 'PHP', 'rate' => 1 ),
		) );
		if ( empty( $tb_currencies ) ) {
			$tb_currencies = array(
				array( 'code' => 'AUD', 'rate' => 0.026 ),
				array( 'code' => 'USD', 'rate' => 0.017 ),
				array( 'code' => 'PHP', 'rate' => 1 ),
			);
		}
		$tb_rates = array();
		foreach ( $tb_currencies as $c ) {
			$tb_rates[ $c['code'] ] = (float) $c['rate'];
		}

		wp_localize_script( 'kings-city-team-builder', 'kcTeamBuilder', array(
			'roleCatalog'   => array_values( $tb_roles_raw ),
			'currencyRates' => $tb_rates,
			'defaultCurr'   => $tb_currencies[0]['code'],
			'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		) );
	}

	// Page-specific: Flatpickr (Book a Tour only)
	if ( is_page_template( 'page-book-now.php' ) ) {
		wp_enqueue_style(
			'flatpickr',
			'https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css',
			array(),
			'4.6.13'
		);
		wp_enqueue_script(
			'flatpickr',
			'https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js',
			array(),
			'4.6.13',
			true
		);
		// Vimeo Player SDK (only when a video ID is present)
		wp_enqueue_script(
			'vimeo-player',
			'https://player.vimeo.com/api/player.js',
			array(),
			null,
			true
		);

		wp_enqueue_script( 'kings-city-booking', get_template_directory_uri() . '/assets/js/booking.js', array( 'flatpickr' ), KINGS_CITY_VERSION, true );

		$bk_spaces = get_posts( array(
			'post_type'      => 'kc_space',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'meta_query'     => array( array( 'key' => 'kc_space_is_active', 'value' => '1' ) ),
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		) );
		$bk_map = array();
		foreach ( $bk_spaces as $bk_sp ) {
			$bk_key = get_field( 'kc_space_booking_key', $bk_sp->ID );
			if ( ! $bk_key ) continue;
			$bk_heading    = get_field( 'kc_space_heading', $bk_sp->ID ) ?: $bk_sp->post_title;
			$bk_overline   = get_field( 'kc_space_form_overline', $bk_sp->ID ) ?: $bk_key;
			$bk_desc1      = get_field( 'kc_space_description_1', $bk_sp->ID ) ?: '';
			$bk_desc2      = get_field( 'kc_space_description_2', $bk_sp->ID ) ?: '';
			$bk_form_title = get_field( 'kc_space_form_title', $bk_sp->ID ) ?: 'Book ' . $bk_heading;
			$bk_img_key    = get_field( 'kc_space_book_image_key', $bk_sp->ID );
			$bk_img        = $bk_img_key ? ( get_field( $bk_img_key, $bk_sp->ID ) ?: get_field( 'kc_space_img_1', $bk_sp->ID ) ) : get_field( 'kc_space_img_1', $bk_sp->ID );
			$bk_img        = $bk_img ?: '';
			$bk_feats_raw  = get_field( 'kc_space_features', $bk_sp->ID ) ?: '';
			$bk_features   = $bk_feats_raw ? array_values( array_filter( array_map( 'trim', explode( "\n", $bk_feats_raw ) ) ) ) : array();
			$bk_opts_raw   = get_field( 'kc_space_pricing_options', $bk_sp->ID ) ?: '';
			$bk_options    = array();
			if ( $bk_opts_raw ) {
				foreach ( array_filter( array_map( 'trim', explode( "\n", $bk_opts_raw ) ) ) as $opt_line ) {
					$parts = explode( '|', $opt_line, 3 );
					if ( count( $parts ) === 3 ) {
						$bk_options[] = array( 'label' => trim( $parts[0] ), 'value' => trim( $parts[1] ), 'price' => (int) trim( $parts[2] ) );
					}
				}
			}
			$bk_text_html = '';
			if ( $bk_desc1 ) $bk_text_html .= '<p>' . esc_html( $bk_desc1 ) . '</p>';
			if ( $bk_desc2 ) $bk_text_html .= '<p>' . esc_html( $bk_desc2 ) . '</p>';
			$bk_map[ $bk_key ] = array(
				'image'     => $bk_img,
				'overline'  => $bk_overline,
				'title'     => $bk_heading,
				'text'      => $bk_text_html,
				'features'  => $bk_features,
				'formTitle' => $bk_form_title,
				'options'   => $bk_options,
			);
		}

		wp_localize_script( 'kings-city-booking', 'kcBooking', array(
			'bookingData' => $bk_map,
			'ajax'        => array(
				'url'         => admin_url( 'admin-ajax.php' ),
				'nonce'       => wp_create_nonce( 'kc_booked_dates_nonce' ),
				'promo_nonce' => wp_create_nonce( 'kc_apply_promo_nonce' ),
			),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'kings_city_scripts' );

function kings_city_messenger_button() {
	?>
	<div class="kc-messenger-wrap" id="kc-messenger-wrap">
		<a
			href="https://m.me/KingsCityPH"
			class="kc-messenger-btn"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="Chat with us on Messenger"
		>
			<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
				<path d="M12 0C5.373 0 0 4.975 0 11.111c0 3.497 1.744 6.615 4.472 8.652V24l4.08-2.241c1.09.301 2.245.463 3.448.463 6.627 0 12-4.975 12-11.111S18.627 0 12 0zm1.191 14.963-3.055-3.26-5.963 3.26 6.556-6.963 3.129 3.26 5.889-3.26-6.556 6.963z"/>
			</svg>
		</a>
		<button
			class="kc-messenger-close"
			aria-label="Dismiss chat button"
			onclick="document.getElementById('kc-messenger-wrap').style.display='none'"
		>
			<svg viewBox="0 0 8 8" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
				<line x1="1" y1="1" x2="7" y2="7"/><line x1="7" y1="1" x2="1" y2="7"/>
			</svg>
		</button>
	</div>
	<?php
}
add_action( 'wp_footer', 'kings_city_messenger_button' );

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
        'Book a Tour'    => 'page-book-now.php',
        '404 Settings'   => 'page-404-settings.php',
    );

    $home_page_id = 0;

    foreach ( $pages as $page_title => $page_template ) {
        $page_check = kc_get_page_id_by_title( $page_title );
        
        $new_page = array(
            'post_type' => 'page',
            'post_title' => $page_title,
            'post_content' => 'Content for ' . $page_title . ' goes here. Edit this in the WordPress admin.',
            'post_status' => 'publish',
            'post_author' => 1,
        );

        if ( ! $page_check ) {
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

// Create any missing auto-populate pages without requiring a theme re-activation.
add_action( 'admin_init', function () {
    $pages = array(
        '404 Settings' => 'page-404-settings.php',
    );
    foreach ( $pages as $title => $template ) {
        if ( ! kc_get_page_id_by_title( $title ) ) {
            $id = wp_insert_post( array(
                'post_type'    => 'page',
                'post_title'   => $title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ) );
            if ( $id && ! is_wp_error( $id ) ) {
                update_post_meta( $id, '_wp_page_template', $template );
            }
        }
    }
});

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

    // 2. Team Builder Role Categories
    register_taxonomy('tb_role_category', array('tb_role'), array(
        'hierarchical' => true,
        'labels' => array(
            'name' => 'Role Categories',
            'singular_name' => 'Role Category',
            'search_items' => 'Search Role Categories',
            'all_items' => 'All Role Categories',
            'parent_item' => 'Parent Role Category',
            'parent_item_colon' => 'Parent Role Category:',
            'edit_item' => 'Edit Role Category',
            'update_item' => 'Update Role Category',
            'add_new_item' => 'Add New Role Category',
            'new_item_name' => 'New Role Category Name',
            'menu_name' => 'Role Categories',
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'role-category'),
    ));

}
add_action('init', 'kings_city_register_cpts');


// Currency Manager
require_once get_template_directory() . '/inc/currency-manager.php';

// News & Insights CPT
require_once get_template_directory() . '/inc/cpt-news.php';

// Spaces CPT
require_once get_template_directory() . '/inc/cpt-spaces.php';

// Quote Requests CRM
require_once get_template_directory() . '/inc/cpt-quotes.php';
require_once get_template_directory() . '/inc/settings-email.php';

// Welcome Packets (Newsletters)
require_once get_template_directory() . '/inc/cpt-welcome-packets.php';

// Mailing List (Stay in the Loop)
require_once get_template_directory() . '/inc/mailing-list.php';

// Booking AJAX — booked dates for calendar
require_once get_template_directory() . '/inc/ajax-booked-dates.php';

// Bookings CRM & Dashboard
require_once get_template_directory() . '/inc/kpi-dashboard.php';
require_once get_template_directory() . '/inc/cpt-bookings.php';
require_once get_template_directory() . '/inc/dashboard-widget.php';

// Promo Codes
require_once get_template_directory() . '/inc/cpt-promos.php';

// Email Campaigns Scheduler
require_once get_template_directory() . '/inc/cpt-campaigns.php';

// ⚠️ DEV ONLY — Remove before going to production! ⚠️
// Adds "Clean Test Data" page under WP Admin → Tools
require_once get_template_directory() . '/inc/dev-cleanup.php';

// Daily cron: auto-expire memberships whose expiry date has passed
if ( ! wp_next_scheduled( 'kc_expire_memberships_daily' ) ) {
    wp_schedule_event( time(), 'daily', 'kc_expire_memberships_daily' );
}
add_action( 'kc_expire_memberships_daily', 'kc_run_membership_expiry' );
function kc_run_membership_expiry() {
    $today   = date( 'Y-m-d' );
    $expired = get_posts( array(
        'post_type'      => 'kc_booking',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => array(
            'relation' => 'AND',
            array( 'key' => 'kc_membership_status', 'value' => 'Active' ),
            array( 'key' => 'kc_membership_expiry', 'value' => $today, 'compare' => '<' ),
        ),
    ) );
    foreach ( $expired as $post_id ) {
        update_post_meta( $post_id, 'kc_membership_status', 'Expired' );
    }
}


// --- AJAX Inline Status Updater ---

add_action('wp_ajax_kc_update_inline_status', 'kc_ajax_update_inline_status');
function kc_ajax_update_inline_status() {
    check_ajax_referer('kc_inline_status_nonce', 'nonce');
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Unauthorized');
    }

    $post_id = intval($_POST['post_id']);
    $post_type = sanitize_text_field($_POST['post_type']);
    $new_status = sanitize_text_field($_POST['new_status']);

    if ($post_type === 'kc_booking') {
        $old_status = get_post_meta($post_id, 'kc_status', true);
        if (!$old_status) $old_status = 'Pending';
        if ($old_status !== $new_status) {
            kc_process_booking_status_change($post_id, $new_status, $old_status);
        }
    } elseif ($post_type === 'kg_quote_lead') {
        $old_status = get_post_meta($post_id, 'lead_status', true);
        if (!$old_status) $old_status = 'Pending';
        if ($old_status !== $new_status) {
            kc_process_quote_status_change($post_id, $new_status, $old_status);
        }
    }

    wp_send_json_success('Updated');
}

// Inject JS for the inline dropdowns on the admin list tables
add_action('admin_footer', 'kc_inline_status_js');
function kc_inline_status_js() {
    $screen = get_current_screen();
    if (!$screen || ($screen->post_type !== 'kc_booking' && $screen->post_type !== 'kg_quote_lead')) {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.kc-inline-status-select').on('change', function() {
            var select = $(this);
            var post_id = select.data('post-id');
            var post_type = select.data('post-type');
            var new_status = select.val();
            var spinner = $('#kc-spinner-' + post_id);

            select.prop('disabled', true);
            spinner.addClass('is-active');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'kc_update_inline_status',
                    nonce: '<?php echo wp_create_nonce("kc_inline_status_nonce"); ?>',
                    post_id: post_id,
                    post_type: post_type,
                    new_status: new_status
                },
                success: function(response) {
                    spinner.removeClass('is-active');
                    select.prop('disabled', false);
                    if(response.success) {
                        var bg = '#fef08a', color = '#854d0e'; // Pending
                        if (new_status === 'Contacted') { bg = '#bfdbfe'; color = '#1e3a8a'; }
                        if (new_status === 'Completed' || new_status === 'Closed') { bg = '#bbf7d0'; color = '#166534'; }
                        if (new_status === 'Rejected' || new_status === 'Cancelled') { bg = '#fecaca'; color = '#991b1b'; }
                        
                        select.css({
                            'background-color': bg,
                            'color': color,
                            'border': '2px solid #10b981' // Temp flash green
                        });
                        setTimeout(function(){ select.css('border', '1px solid ' + color); }, 1500);
                    } else {
                        alert('Error updating status.');
                    }
                },
                error: function() {
                    spinner.removeClass('is-active');
                    select.prop('disabled', false);
                    alert('Server error.');
                }
            });
        });
    });
    </script>
    <?php
}

/**
 * Helper function for ACF images with a local theme fallback.
 * Allows images to be cleared from the WP Media Library without breaking the site.
 */
// Resolves an ACF URL field so it works on both localhost and production.
// - Anchors (#section) and full URLs (https://) pass through unchanged.
// - Relative paths (/page/) are prepended with home_url() so they resolve
//   correctly regardless of whether WP is installed in a subdirectory.
function kc_url($acf_field_name, $fallback = '', $post_id = false) {
    $value = get_field($acf_field_name, $post_id) ?: $fallback;
    if (!$value) return '';
    if ($value[0] === '#' || preg_match('#^https?://#i', $value)) {
        return esc_url($value);
    }
    return esc_url(home_url('/' . ltrim($value, '/')));
}

function kc_img($acf_field_name, $fallback_image_path, $post_id = false) {
    $img = get_field($acf_field_name, $post_id);
    // If image exists in ACF (Wordpress Admin), use it
    if ($img && isset($img['url'])) {
        return esc_url($img['url']);
    }
    // Otherwise, fallback to the local theme image!
    return get_template_directory_uri() . '/assets/img/' . ltrim($fallback_image_path, '/');
}

// Strip legacy HTML markup from button label fields that were previously wysiwyg.
// This runs on load so the admin shows plain text; once saved it stores clean values.
add_filter('acf/load_value/name=hero_section_txt_7', 'kc_strip_btn_label_html', 10, 3);
add_filter('acf/load_value/name=section_txt_36',     'kc_strip_btn_label_html', 10, 3);
function kc_strip_btn_label_html($value, $post_id, $field) {
    return $value ? trim(wp_strip_all_tags($value)) : $value;
}

// ── Space card click tracker ──────────────────────────────────────────────────
// Valid space keys map to wp_options counter keys.
function kc_space_click_keys() {
    return array(
        'coworking'      => 'kc_clicks_coworking',
        'private-office' => 'kc_clicks_private_office',
        'enterprise'     => 'kc_clicks_enterprise',
        'on-demand'      => 'kc_clicks_on_demand',
        'virtual-office' => 'kc_clicks_virtual_office',
        'meeting-rooms'  => 'kc_clicks_meeting_rooms',
    );
}

// PHP redirect handler: ?kc_track=coworking → increments counter → redirects to spaces page.
add_action('template_redirect', function () {
    if ( ! isset($_GET['kc_track']) ) return;

    $space    = sanitize_key($_GET['kc_track']);
    $map      = kc_space_click_keys();

    if ( isset($map[$space]) ) {
        $current = (int) get_option($map[$space], 0);
        update_option($map[$space], $current + 1, false);
    }

    $spaces_url = kc_url('proposed_space_btn_url', '/spaces/', get_queried_object_id());
    wp_redirect($spaces_url, 302);
    exit;
});
