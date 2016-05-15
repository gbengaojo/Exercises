<?php
/**
 * fCorpo functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @subpackage fCorpo
 * @author tishonator
 * @since fCorpo 1.0.0
 *
 */

if ( ! function_exists( 'fcorpo_setup' ) ) {
	/**
	 * fCorpo setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 */
	function fcorpo_setup() {

		load_theme_textdomain( 'fcorpo', get_template_directory() . '/languages' );

		add_theme_support( "title-tag" );

		// add the visual editor to resemble the theme style
		add_editor_style( array( 'css/editor-style.css' ) );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => __( 'primary menu', 'fcorpo' ),
		) );

		// add Custom background				 
		add_theme_support( 'custom-background', 
					   array ('default-color'  => '#FFFFFF')
					 );


		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 0, true );

		if ( ! isset( $content_width ) )
			$content_width = 900;

		add_theme_support( 'automatic-feed-links' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form', 'comment-list',
		) );

		// add custom header
		add_theme_support( 'custom-header', array (
						   'default-image'          => '',
						   'random-default'         => '',
						   'width'                  => 145,
						   'height'                 => 36,
						   'flex-height'            => '',
						   'flex-width'             => '',
						   'default-text-color'     => '',
						   'header-text'            => '',
						   'uploads'                => true,
						   'wp-head-callback'       => '',
						   'admin-head-callback'    => '',
						   'admin-preview-callback' => '',
						) );

		
	}
} // fcorpo_setup
add_action( 'after_setup_theme', 'fcorpo_setup' );

/**
 * the main function to load scripts in the fCorpo theme
 * if you add a new load of script, style, etc. you can use that function
 * instead of adding a new wp_enqueue_scripts action for it.
 */
function fcorpo_load_scripts() {

	// load main stylesheet.
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( ) );
	wp_enqueue_style( 'fcorpo-style', get_stylesheet_uri(), array( ) );
	
	wp_enqueue_style( 'fcorpo-fonts', fcorpo_fonts_url(), array(), null );
	
	// Load thread comments reply script	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fcorpo-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );

	// Load Slider JS Scripts
	wp_enqueue_script( 'jquery.mobile.customized', get_template_directory_uri() . '/js/jquery.mobile.customized.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery.easing.1.3', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ) );
	wp_enqueue_script( 'camera', get_template_directory_uri() . '/js/camera.min.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'fcorpo_load_scripts' );

/**
 *	Load google font url used in the fCorpo theme
 */
function fcorpo_fonts_url() {

    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by PT Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $cantarell = _x( 'on', 'PT Sans font: on or off', 'fcorpo' );

    if ( 'off' !== $cantarell ) {
        $font_families = array();
 
        $font_families[] = 'PT Sans';
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,cyrillic-ext,cyrillic,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 * Display website's logo image
 */
function fcorpo_show_website_logo_image_or_title() {

	if ( get_header_image() != '' ) {
	
		// Check if the user selected a header Image in the Customizer or the Header Menu
		$logoImgPath = get_header_image();
		$siteTitle = get_bloginfo( 'name' );
		$imageWidth = get_custom_header()->width;
		$imageHeight = get_custom_header()->height;
		
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<img src="' . esc_url( $logoImgPath ) . '" alt="' . esc_attr( $siteTitle ) . '" title="' . esc_attr( $siteTitle ) . '" width="' . esc_attr( $imageWidth ) . '" height="' . esc_attr( $imageHeight ) . '" />';
		
		echo '</a>';

	} else {
	
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<h1>'.get_bloginfo('name').'</h1>';
		
		echo '</a>';
		
		echo '<strong>'.get_bloginfo('description').'</strong>';
	}
}

/**
 *	Displays the copyright text.
 */
function fcorpo_show_copyright_text() {

	$footerText = get_theme_mod('fcorpo_footer_copyright', null);

	if ( !empty( $footerText ) ) {

		echo esc_html( $footerText ) . ' | ';		
	}
}

/**
 *	widgets-init action handler. Used to register widgets and register widget areas
 */
function fcorpo_widgets_init() {
	
	// Register Sidebar Widget.
	register_sidebar( array (
						'name'	 		 =>	 __( 'Sidebar Widget Area', 'fcorpo'),
						'id'		 	 =>	 'sidebar-widget-area',
						'description'	 =>  __( 'The sidebar widget area', 'fcorpo'),
						'before_widget'	 =>  '',
						'after_widget'	 =>  '',
						'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
						'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
					) );
}
add_action( 'widgets_init', 'fcorpo_widgets_init' );

/**
 * Displays the slider
 */
function fcorpo_display_slider() { ?>
	 
	<div class="camera_wrap camera_emboss" id="camera_wrap">
		<?php
			// display slides
			for ( $i = 1; $i <= 3; ++$i ) {

					$defaultSlideContent = __( '<h3>Lorem ipsum dolor</h3><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fcorpo' );
					
					$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';

					$slideContent = get_theme_mod( 'fcorpo_slide'.$i.'_content', html_entity_decode( $defaultSlideContent ) );
					$slideImage = get_theme_mod( 'fcorpo_slide'.$i.'_image', $defaultSlideImage );

				?>

					<div data-thumb="<?php echo esc_attr( $slideImage ); ?>" data-src="<?php echo esc_attr( $slideImage ); ?>">
						<div class="camera_caption fadeFromBottom">
							<?php echo $slideContent; ?>
						</div>
					</div>
<?php		} ?>
	</div><!-- #camera_wrap -->
<?php  
}

function fcorpo_display_social_sites() {

	echo '<ul class="header-social-widget">';

	$socialURL = get_theme_mod('fcorpo_social_facebook', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Facebook', 'fcorpo') . '" class="facebook16"></a>';
	}

	$socialURL = get_theme_mod('fcorpo_social_google', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Google+', 'fcorpo') . '" class="google16"></a>';
	}

	$socialURL = get_theme_mod('fcorpo_social_rss', get_bloginfo( 'rss2_url' ));
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow our RSS Feeds', 'fcorpo') . '" class="rss16"></a>';
	}

	$socialURL = get_theme_mod('fcorpo_social_youtube', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Youtube', 'fcorpo') . '" class="youtube16"></a>';
	}

	echo '</ul>';
}

/**
 * Register theme settings in the customizer
 */
function fcorpo_customize_register( $wp_customize ) {

	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'fcorpo_slider_section',
		array(
			'title'       => __( 'Slider', 'fcorpo' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	for ($i = 1; $i <= 3; ++$i) {
	
		$slideContentId = 'fcorpo_slide'.$i.'_content';
		$slideImageId = 'fcorpo_slide'.$i.'_image';
		$defaultSliderImagePath = get_template_directory_uri().'/images/slider/'.$i.'.jpg';
	
		// Add Slide Content
		$wp_customize->add_setting(
			$slideContentId,
			array(
				'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fcorpo' ),
				'sanitize_callback' => 'force_balance_tags',
			)
		);
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $slideContentId,
									array(
										'label'          => sprintf( __( 'Slide #%s Content', 'fcorpo' ), $i ),
										'section'        => 'fcorpo_slider_section',
										'settings'       => $slideContentId,
										'type'           => 'textarea',
										)
									)
		);
		
		// Add Slide Background Image
		$wp_customize->add_setting( $slideImageId,
			array(
				'default' => $defaultSliderImagePath,
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $slideImageId,
				array(
					'label'   	 => sprintf( __( 'Slide #%s Image', 'fcorpo' ), $i ),
					'section' 	 => 'fcorpo_slider_section',
					'settings'   => $slideImageId,
				) 
			)
		);
	}

	/**
	 * Add Footer Section
	 */
	$wp_customize->add_section(
		'fcorpo_footer_section',
		array(
			'title'       => __( 'Footer', 'fcorpo' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add footer copyright text
	$wp_customize->add_setting(
		'fcorpo_footer_copyright',
		array(
		    'default'           => '',
		    'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fcorpo_footer_copyright',
        array(
            'label'          => __( 'Copyright Text', 'fcorpo' ),
            'section'        => 'fcorpo_footer_section',
            'settings'       => 'fcorpo_footer_copyright',
            'type'           => 'text',
            )
        )
	);

	/**
	 * Add Social Sites Section
	 */
	$wp_customize->add_section(
		'fcorpo_social_section',
		array(
			'title'       => __( 'Social Sites', 'fcorpo' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add facebook url
	$wp_customize->add_setting(
		'fcorpo_social_facebook',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fcorpo_social_facebook',
        array(
            'label'          => __( 'Facebook Page URL', 'fcorpo' ),
            'section'        => 'fcorpo_social_section',
            'settings'       => 'fcorpo_social_facebook',
            'type'           => 'text',
            )
        )
	);

	// Add google+ url
	$wp_customize->add_setting(
		'fcorpo_social_google',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fcorpo_social_google',
        array(
            'label'          => __( 'Google+ Page URL', 'fcorpo' ),
            'section'        => 'fcorpo_social_section',
            'settings'       => 'fcorpo_social_google',
            'type'           => 'text',
            )
        )
	);

	// Add RSS Feeds url
	$wp_customize->add_setting(
		'fcorpo_social_rss',
		array(
		    'default'           => get_bloginfo( 'rss2_url' ),
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fcorpo_social_rss',
        array(
            'label'          => __( 'RSS Feeds URL', 'fcorpo' ),
            'section'        => 'fcorpo_social_section',
            'settings'       => 'fcorpo_social_rss',
            'type'           => 'text',
            )
        )
	);

	// Add YouTube channel url
	$wp_customize->add_setting(
		'fcorpo_social_youtube',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fcorpo_social_youtube',
        array(
            'label'          => __( 'YouTube channel URL', 'fcorpo' ),
            'section'        => 'fcorpo_social_section',
            'settings'       => 'fcorpo_social_youtube',
            'type'           => 'text',
            )
        )
	);
}
add_action('customize_register', 'fcorpo_customize_register');

/*
Enqueue Script for top buttons
*/
function fcorpo_customizer_controls(){

	wp_register_script( 'fcorpo_customizer_top_buttons', get_template_directory_uri() . '/js/customizer-top-buttons.js', array( 'jquery' ), true  );
	wp_enqueue_script( 'fcorpo_customizer_top_buttons' );

	wp_localize_script( 'fcorpo_customizer_top_buttons', 'customBtns', array(
		'prodemo' => esc_html__( 'Demo Premium version', 'fcorpo' ),
        'proget' => esc_html__( 'Get Premium version', 'fcorpo' )
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'fcorpo_customizer_controls' );

?>
