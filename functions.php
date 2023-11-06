<?php
/**
 * Uweed functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Uweed
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function uweed_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Uweed, use a find and replace
		* to change 'uweed' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'uweed', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'uweed' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'uweed_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'uweed_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function uweed_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'uweed_content_width', 640 );
}
add_action( 'after_setup_theme', 'uweed_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function uweed_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'uweed' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'uweed' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'uweed_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function uweed_scripts() {
	wp_enqueue_style( 'uweed-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'uweed-style', 'rtl', 'replace' );

	wp_enqueue_script( 'uweed-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'uweed_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs',10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );

add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['additional_information']['title'] = __( 'Package type','uweed' );	
// Rename the additional information tab
	return $tabs;

}

add_action( 'woocommerce_before_single_product', 'disable_variable_product_selects_unless_previous_selected' );
 
function disable_variable_product_selects_unless_previous_selected() {
   global $product;
   if ( ! $product->is_type( 'variable' ) ) return; 
   if ( count( $product->get_available_variations() ) < 2 ) return; 
   wc_enqueue_js( "
      function toggle_attributes() {
         $('table.variations tbody tr').each(function(){
            if ($(this).prev().find('td.value select').val()=='') {
               $(this).find('td.value select').attr('disabled',true).val(''); // if previous has no value, disable and reset
            } else $(this).find('td.value select').attr('disabled',false);
         });
      }
      toggle_attributes();
      $('table.variations select').change( function(){
         toggle_attributes();
      });
   " );
}


add_filter( 'woocommerce_output_related_products_args', 'change_number_related_products', 9999 );
 
function change_number_related_products( $args ) {
 $args['posts_per_page'] = 3;
 $args['columns'] = 3; 
 return $args;
}

add_filter( 'woocommerce_product_add_to_cart_text', 'change_select_options_button_text', 9999, 2 );
 
function change_select_options_button_text( $label, $product ) {
   if ( $product->is_type( 'variable' ) ) {
      return 'View Product';
   }
   return $label;
}


function custom_enqueue_scripts() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            
            $('#size').change(function () {
                var selectedSize = $(this).val();
                var quantityLabel = $('label[for="quantity-weight"]');

                if (selectedSize === 'Large') {
                 
                    quantityLabel.text('Weight');
                } else if (selectedSize === '') {
                    
                    quantityLabel.text('Quantity/Weight');
                } else {
                    
                    quantityLabel.text('Quantity');
                }
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_enqueue_scripts');
