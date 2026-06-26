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
        'Book a Tour' => 'page-book-now.php'
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

// Quote Requests CRM
require_once get_template_directory() . '/inc/cpt-quotes.php';

// Bookings CRM & Dashboard
require_once get_template_directory() . '/inc/settings-capacity.php';
require_once get_template_directory() . '/inc/kpi-dashboard.php';
require_once get_template_directory() . '/inc/cpt-bookings.php';
require_once get_template_directory() . '/inc/dashboard-widget.php';


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
