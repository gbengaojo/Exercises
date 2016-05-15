<?php
/**
 * 8Store Lite functions and definitions
 *
 * @package 8Store Lite
 */

if ( ! function_exists( 'eightstore_lite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eightstore_lite_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on 8Store Lite, use a find and replace
	 * to change 'eightstore-lite' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'eightstore-lite', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size('eightstore-promo-small', 520, 260, true);
	add_image_size('eightstore-promo-large', 520, 520, true);
	add_image_size('eightstore-blog-image', 290, 260, true);
	add_image_size('eightstore-testimonial-image', 70, 70, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'eightstore-lite' ),
		) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'eightstore_lite_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
		) ) );
}
endif; // eightstore_lite_setup
add_action( 'after_setup_theme', 'eightstore_lite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eightstore_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eightstore_lite_content_width', 640 );
}
add_action( 'after_setup_theme', 'eightstore_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function eightstore_lite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'eightstore-lite' ),
		'id'            => 'sidebar-1',
		'description'   => 'Sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'eightstore-lite' ),
		'id'            => 'shop',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="%2$s '.eightstore_lite_count_widgets( 'shop' ).'">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
		) );

	register_sidebar( array(
		'name'          => esc_html__( 'Language Translator', 'eightstore-lite' ),
		'id'            => 'eightstore-lite-language-option',
		'description'   => 'Add Plugin and place its widget here.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Product Widget 1', 'eightstore-lite' ),
		'id'            => 'widget-product-1',
		'description'   => 'Show a slider of product',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Promo Widget 1', 'eightstore-lite' ),
		'id'            => 'widget-promo-1',
		'description'   => 'Show banner or text or some call to action',
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.eightstore_lite_count_widgets('widget-promo-1').'">',
		'after_widget'  => '</aside>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Category Widget 1', 'eightstore-lite' ),
		'id'            => 'widget-category-1',
		'description'   => 'Show a slider with category details and product of it.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Promo Widget 2', 'eightstore-lite' ),
		'id'            => 'widget-promo-2',
		'description'   => 'Show banner or text or some call to action',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Category Widget 2', 'eightstore-lite' ),
		'id'            => 'widget-category-2',
		'description'   => 'Show a slider with category details and product of it.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Promo Widget 3', 'eightstore-lite' ),
		'id'            => 'widget-promo-3',
		'description'   => 'Show banner or text or some call to action',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Product Widget 2', 'eightstore-lite' ),
		'id'            => 'widget-product-2',
		'description'   => 'Show a slider of product',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );	
	
	register_sidebar( array(
		'name'          => esc_html__( 'Promo Widget 4', 'eightstore-lite' ),
		'id'            => 'widget-promo-4',
		'description'   => 'Show banner or text or some call to action',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	
	register_sidebar( array(
		'name'          => __( 'Sidebar - Left', 'eightstore-lite' ),
		'id'            => 'sidebar-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		) );
	
	register_sidebar( array(
		'name'          => __( 'Sidebar - Right', 'eightstore-lite' ),
		'id'            => 'sidebar-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s ">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Top Footer Widgets', 'eightstore-lite' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="top-footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="footer-widget-title">',
		'after_title'   => '</h2>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'eightstore-lite' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="main-footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="footer-widget-title">',
		'after_title'   => '</h2>',
		) );
}
add_action( 'widgets_init', 'eightstore_lite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eightstore_lite_scripts() {

	$font_args = array(
		'family' => 'Open+Sans:400,600,700,300|Oswald:400,700,300|Dosis:400,300,500,600,700|Lato:400,300,700,900',
		);
	wp_enqueue_style('eightstore-google-fonts', add_query_arg($font_args, "//fonts.googleapis.com/css"));
	
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );

	wp_enqueue_style( 'eightstore-animate', get_template_directory_uri() . '/css/animate.css');
	
	wp_enqueue_style( 'eightstore-slick', get_template_directory_uri() . '/css/slick.css');

	wp_enqueue_style( 'eightstore-fancybox', get_template_directory_uri() . '/css/fancybox.css');

	wp_enqueue_style( 'eightstore-style', get_stylesheet_uri() );

	//check if responsive mode is enabled.
	if(get_theme_mod('is_mode_responsive')!='1'){
		wp_enqueue_style( 'eightstore-responsive', get_template_directory_uri() . '/css/responsive.css');
	}

	wp_enqueue_script( 'eightstore-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel-3.0.4.pack.js', array('jquery'), '3.0.4', true );
	wp_enqueue_script( 'eightstore-fancybox', get_template_directory_uri() . '/js/jquery.fancybox-1.3.4.js', array('jquery'), '1.3.4', true );

	wp_enqueue_script( 'eightstore-wow', get_template_directory_uri() . '/js/wow.min.js',array(),'1.1.2',true);

	wp_enqueue_script( 'eightstore-slick', get_template_directory_uri() . '/js/slick.js', array('jquery'), '1.5.0', true );


	wp_enqueue_script( 'eightstore-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'eightstore-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script('eightstore-custom-scripts', get_template_directory_uri() . '/js/custom-scripts.js', array(), '20150611', true );
}
add_action( 'wp_enqueue_scripts', 'eightstore_lite_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Custom functions file.
 */
require get_template_directory() . '/inc/eightstore-functions.php';
/**
 * Custom Customizer additions.
 */
require get_template_directory() . '/inc/eightstore-customizer.php';

/**
 * Custom Sanitizer additions.
 */
require get_template_directory() . '/inc/eightstore-sanitizer.php';
/**
 * Custom Metabox Additions.
 */
require get_template_directory() . '/inc/eightstore-metabox.php';

/**
 * Custom Typography dropdown
 */
require get_template_directory() . '/inc/typography-dropdown.php';
/**
 * Custom Control Type additions.
 */
require get_template_directory() . '/inc/controls/custom-switch.php';
require get_template_directory() . '/inc/controls/custom-chooseimage.php';
require get_template_directory() . '/inc/controls/category-dropdown.php';

/**
 * Custom Widget Types additions.
 */
require get_template_directory() . '/inc/widgets/es-widgets.php';
/**
 * Load Custom Styles
 */
require get_template_directory() . '/css/config-styles.php';
/**
 * Load Custom Plugin Suggestion
 */
require get_template_directory() . '/inc/eightstore-tgm.php';