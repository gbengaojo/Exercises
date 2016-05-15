<?php
/**
 * 8Store Lite Theme Customizer Custom
 *
 * @package 8Store Lite
 */

/**
 * Add new options the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function eightstore_lite_custom_customize_register( $wp_customize ) {
	//Adding the General Setup Panel
	$wp_customize->add_panel('general_setups',array(
		'priority' => '10',
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('General Setup','eightstore-lite'),
		'description' => __('Manage General Setup for the site','eightstore-lite')
		));

	//Add Default Sections to General Panel
	$wp_customize->get_section('title_tagline')->panel = 'general_setups'; //priority 20
	$wp_customize->get_section('colors')->panel = 'general_setups'; //priority 40
	$wp_customize->get_section('header_image')->panel = 'general_setups'; //priority 60
	$wp_customize->get_section('background_image')->panel = 'general_setups'; //priority 80
	//$wp_customize->get_section('nav')->panel = 'general_setups'; //priority 100
	$wp_customize->get_section('static_front_page')->panel = 'general_setups'; //priority 120

	$wp_customize->add_section('header_search',array(
		'title' => __('Header Search Setting','eightstore-lite'),
		'priority' => '25',
		'panel' => 'general_setups'
		));
	$wp_customize->add_setting('hide_header_search',array(
		'default' => '0',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));
	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'hide_header_search',array(
		'type' => 'switch',
		'label' => __('Hide Search From Header','eightstore-lite'),
		'description' => __('Selecting Yes will Hide Search Bar From Header','eightstore-lite'),
		'section' => 'header_search'
		)));
	
	//Webpage Layout
	$wp_customize->add_section('webpage_layout',array(
		'title'            =>       __('Layout Setting', 'eightstore-lite'),
		'priority'         =>      '140',
		'panel'            =>      'general_setups',
		));

	$wp_customize->add_setting('webpage_layout',array(
		'default'       =>  'fullwidth',
		'sanitize_callback' => 'eightstore_lite_sanitize_radio_webpagelayout'
		));

	$wp_customize->add_control('webpage_layout',array(
		'type' => 'radio',
		'label' => __('Website Layout', 'eightstore-lite'),
		'description' => __('Make your website either box layout or full width from click away', 'eightstore-lite'),
		'section' => 'webpage_layout',
		'choices' => array(
			'boxed' => __('Boxed Layout', 'eightstore-lite'),
			'fullwidth' => __('Full Width', 'eightstore-lite')
			)
		));
	
	//Footer Copyright Text
	$wp_customize->add_section('footer_copyright',
		array(
			'title' => __('Footer Copyright Area', 'eightstore-lite'),
			'priority' => '150',
			'panel' => 'general_setups'
			)
		);

	$wp_customize->add_setting('footer_copyright_text',array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('footer_copyright_text',array(
		'type' => 'textarea',
		'label' => __('Footer Copyright Area Text', 'eightstore-lite'),
		'description' => __('Enter text or Html to show in the footer.', 'eightstore-lite'),
		'section' => 'footer_copyright',
		));

	//Responsive Setting
	$wp_customize->add_section('responsive_setting',
		array(
			'title' => __('Responsive Mode', 'eightstore-lite'),
			'priority' => '160',
			'panel' => 'general_setups'
			)
		);

	$wp_customize->add_setting('is_mode_responsive',array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'is_mode_responsive',array(
		'type' => 'switch',
		'label' => __('Disable Responsive Design', 'eightstore-lite'),
		'description' => __('Selecting Yes will disable the responsive design','eightstore-lite'),
		'section' => 'responsive_setting'
		)));

	//Add New Panel for topheader Setups
	$wp_customize->add_panel('home_topheader_setups',array(
		'priority' => '10',
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Top Header Setup', 'eightstore-lite' ),
		'description' => __( 'Setup the ticker,call to for top header', 'eightstore-lite' ),
		));

	$wp_customize->add_section('eightstore_ticker',array(
		'title'           =>      __('Ticker Setting', 'eightstore-lite'),
		'priority'        =>      '2',
		'panel' => 'home_topheader_setups'
		));

	$wp_customize->add_setting('eightstore_ticker_checkbox',array(
		'default' =>  '1',
		'sanitize_callback'     =>  'eightstore_lite_checkbox_sanitize'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'eightstore_ticker_checkbox',array(
		'section'       =>      'eightstore_ticker',
		'label'         =>      __('Enable Ticker', 'eightstore-lite'),
		'type'          =>      'switch',
		'output'        =>      array('Yes', 'No')
		)));
	//ticker title
	$wp_customize->add_setting('eightstore_ticker_title',array(
		'default'       =>      'Latest',
		'sanitize_callback'     =>  'eightstore_lite_sanitize_text'
		));
	$wp_customize->add_control('eightstore_ticker_title',array(
		'section'       =>      'eightstore_ticker',
		'label'         =>      __('Ticker Title', 'eightstore-lite'),
		'type'          =>      'text'
		));

	//select category for ticker
	$wp_customize->add_setting('ticker_setting_category',array(
		'default' => '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));

	$wp_customize->add_control( new Eightstore_lite_WP_Customize_Category_Control( $wp_customize,'ticker_setting_category', array(
		'label' => __('Select a category to show in ticker','eightstore-lite'),
		'section' => 'eightstore_ticker',
		)));

	$wp_customize->add_section('top_header_callto',array(
		'title' => __('Top Header Call-To','eightstore-lite'),
		'priority' => '10',
		'panel' => 'home_topheader_setups'
		));
	$wp_customize->add_setting('callto_text',array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		'transport' => 'postMessage'
		));
	$wp_customize->add_control('callto_text',array(
		'type' => 'textarea',
		'label' => __('Call To Content','eightstore-lite'),
		'description' => 'Enter text or HTML for call to action',
		'section' => 'top_header_callto'
		));

	//Add New Panel for Homepage Sections
	$wp_customize->add_panel('homepage_sections',array(
		'priority' => '20',
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Homepage Sections', 'eightstore-lite' ),
		'description' => __( 'Setup some sections of homepage, Some sections are available from widgets', 'eightstore-lite' ),
		));

	//Slider Baisc setup sections
	$wp_customize->add_section('gs_slider',array(
		'priority'        =>      '10',
		'title' => __( 'Slider Setup', 'eightstore-lite' ),
		'description' => __( 'Setup the slider banner and other settings for homepage', 'eightstore-lite' ),
		'panel' => 'homepage_sections'
		));
	$wp_customize->add_setting('display_slider',array(
		'default' => '1',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));
	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'display_slider',array(
		'type' => 'switch_yesno',
		'label' => __('Display Slider on Homepage', 'eightstore-lite'),
		'section' => 'gs_slider',
		'output' => array('Yes', 'No')
		)));

	//select category for slider
	$wp_customize->add_setting('slider_setting_category',array(
		'default' => '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));

	$wp_customize->add_control( new Eightstore_lite_WP_Customize_Category_Control( $wp_customize,'slider_setting_category', array(
		'label' => __('Select a category to show in slider','eightstore-lite'),
		'section' => 'gs_slider',
		)));

	$wp_customize->add_setting('display_pager',array(
		'default' => '1',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));
	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'display_pager',array(
		'type' => 'switch_yesno',
		'label' => __('Display Pagers of Slider', 'eightstore-lite'),
		'section' => 'gs_slider',
		'output' => array('Yes', 'No')
		)));
	$wp_customize->add_setting('display_controls',array(
		'default' => '1',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));
	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'display_controls',array(
		'type' => 'switch_yesno',
		'label' => __('Display Controls of Slider', 'eightstore-lite'),
		'section' => 'gs_slider',
		'output' => array('Yes', 'No')
		)));
	$wp_customize->add_setting('enable_auto_transition',array(
		'default' => '1',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));
	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'enable_auto_transition',array(
		'type' => 'switch_yesno',
		'label' => __('Turn on auto transition of slider', 'eightstore-lite'),
		'section' => 'gs_slider',
		'output' => array('Yes', 'No')
		)));
	//transition type
	$wp_customize->add_setting('transition_type', array(
		'default' => 'false',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_transition_type'
		));

	$wp_customize->add_control('transition_type', array(
		'type' => 'select',
		'label' => __('Transition Type(Slide/Fade)', 'eightstore-lite'),
		'section' => 'gs_slider',
		'choices' => array(
			'true' => __('Fade', 'eightstore-lite'),
			'false' => __('Slide', 'eightstore-lite'),
			)
		));
	$wp_customize->add_setting('transition_speed',array(
		'default'       =>      '1000',
		'sanitize_callback' => 'eightstore_lite_sanitize_text'
		));
	$wp_customize->add_control('transition_speed',array(
		'type' => 'text',
		'label' => __('Transition Speed', 'eightstore-lite'),
		'section' => 'gs_slider',
		));
	$wp_customize->add_setting('display_captions',array(
		'default' => '1',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));
	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'display_captions',array(
		'type' => 'switch_yesno',
		'label' => __('Display Captions over Slider', 'eightstore-lite'),
		'description' => __('Display titles and description over Slider', 'eightstore-lite'),
		'section' => 'gs_slider',
		'output' => array('Yes', 'No')
		)));

	//section block below slider
	$wp_customize->add_section('eightstore_category_promo',array(
		'title'           =>      __('Promotional Block Below Slider', 'eightstore-lite'),
		'priority'        =>      '20',
		'panel' => 'homepage_sections'
		));

	//select category for promotional block
	$wp_customize->add_setting('es_category_promo_setting_category',array(
		'default' => '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));

	$wp_customize->add_control( new Eightstore_lite_WP_Customize_Category_Control( $wp_customize,'es_category_promo_setting_category', array(
		'label' => __('Select a category to show in Category Promotional Block','eightstore-lite'),
		'section' => 'eightstore_category_promo',
		)));

	//newsletter section
	$wp_customize->add_section('eightstore_form',array(
		'title'           =>      __('Newsletter Form Setting', 'eightstore-lite'),
		'priority'        =>      '30',
		'panel' => 'homepage_sections'
		));

	//testimonial title
	$wp_customize->add_setting('eightstore_form_shortcode',array(
		'default'       =>      '',
		'sanitize_callback'     =>  'eightstore_lite_sanitize_text'
		));
	$wp_customize->add_control('eightstore_form_shortcode',array(
		'section'       =>      'eightstore_form',
		'label'         =>      __('Newsletter Form Shortcode', 'eightstore-lite'),
		'description'         =>      __('Add form shortcode e.g.[ufbl form_id="1"]', 'eightstore-lite'),
		'type'          =>      'text'
		));

	//blog section
	$wp_customize->add_section('eightstore_blog',array(
		'title'           =>      __('Blog Setting', 'eightstore-lite'),
		'priority'        =>      '30',
		'panel' => 'homepage_sections'
		));

	$wp_customize->add_setting('eightstore_blog_section',array(
		'default' =>  '0',
		'sanitize_callback'     =>  'eightstore_lite_checkbox_sanitize'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'eightstore_blog_section',array(
		'section'       =>      'eightstore_blog',
		'label'         =>      __('Enable Blog Section', 'eightstore-lite'),
		'type'          =>      'switch',
		'output'        =>      array('Yes', 'No')
		)));
	
	//blog title
	$wp_customize->add_setting('eightstore_blog_title',array(
		'default'       =>      'Our Blogs',
		'sanitize_callback'     =>  'eightstore_lite_sanitize_text'
		));
	$wp_customize->add_control('eightstore_blog_title',array(
		'section'       =>      'eightstore_blog',
		'label'         =>      __('Blog Title', 'eightstore-lite'),
		'type'          =>      'text'
		));

	//select category for blog
	$wp_customize->add_setting('eightstore_blog_setting_category',array(
		'default' => '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));

	$wp_customize->add_control( new Eightstore_lite_WP_Customize_Category_Control( $wp_customize,'eightstore_blog_setting_category', array(
		'label' => __('Select a category to show in blog','eightstore-lite'),
		'section' => 'eightstore_blog',
		)));

	//testimonial section
	$wp_customize->add_section('eightstore_testimonial',array(
		'title'           =>      __('Testimonial Setting', 'eightstore-lite'),
		'priority'        =>      '40',
		'panel' => 'homepage_sections'
		));

	$wp_customize->add_setting('eightstore_testimonial_section',array(
		'default' =>  '0',
		'sanitize_callback'     =>  'eightstore_lite_checkbox_sanitize'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'eightstore_testimonial_section',array(
		'section'       =>      'eightstore_testimonial',
		'label'         =>      __('Enable Testimonial Section', 'eightstore-lite'),
		'type'          =>      'switch',
		'output'        =>      array('Yes', 'No')
		)));
	
	//testimonial title
	$wp_customize->add_setting('eightstore_testimonial_title',array(
		'default'       =>      'Our Testimonials',
		'sanitize_callback'     =>  'eightstore_lite_sanitize_text'
		));
	$wp_customize->add_control('eightstore_testimonial_title',array(
		'section'       =>      'eightstore_testimonial',
		'label'         =>      __('Testimonial Title', 'eightstore-lite'),
		'type'          =>      'text'
		));

	//select category for testimonial
	$wp_customize->add_setting('eightstore_testimonial_setting_category',array(
		'default' => '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer'
		));

	$wp_customize->add_control( new Eightstore_lite_WP_Customize_Category_Control( $wp_customize,'eightstore_testimonial_setting_category', array(
		'label' => __('Select a category to show in testimonial','eightstore-lite'),
		'section' => 'eightstore_testimonial',
		)));

		//Adding the Inner Pages Panel
	$wp_customize->add_panel('inner_page_setups',array(
		'priority' => '25',
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('Inner Page Setup','eightstore-lite'),
		'description' => __('Manage inner page setup for the site','eightstore-lite')
		));
		//single page landing page layout
	
	//Single Page
	$wp_customize->add_section('single_page_settings',array(
		'title' => __('Single Page Settings', 'eightstore-lite'),
		'priority' => '150',
		'panel' => 'inner_page_setups'
		));

	$wp_customize->add_setting('single_page_layout',array(
		'default'=>'sidebar-right',
		'sanitize_callback' => 'eightstore_lite_sanitize_page_layouts'
		));

	//define image path
	$imagepath =  get_template_directory_uri() . '/inc/images/';                           
	$wp_customize->add_control( new Eightstore_lite_WP_Customize_ChooseImage_Control($wp_customize,'single_page_layout',array(
		'type' => 'radioimage',
		'label' => __('Single Page Layout', 'eightstore-lite'),
		'description' => __('Choose layout for single page landing webpage', 'eightstore-lite'),
		'section' => 'single_page_settings',
		'choices' => array( 
			'sidebar-left' => $imagepath.'sidebar-left.png',  
			'sidebar-right' => $imagepath.'sidebar-right.png', 
			'sidebar-both' => $imagepath.'sidebar-both.png',
			'sidebar-no' => $imagepath.'sidebar-no.png',
			)
		)));

	$wp_customize->add_setting('eightstore_inner_cta',array(
		'default' =>  '0',
		'sanitize_callback'     =>  'eightstore_lite_checkbox_sanitize'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'eightstore_inner_cta',array(
		'section'       =>      'single_page_settings',
		'label'         =>      __('Enable Call to Action Section', 'eightstore-lite'),
		'description'         =>      __('Call to Action Section added on Widget Promo 3 on Inner Pages', 'eightstore-lite'),
		'type'          =>      'switch',
		'output'        =>      array('Yes', 'No')
		)));

		//Single Post
	$wp_customize->add_section('single_post_settings',array(
		'title' => __('Single Post Settings', 'eightstore-lite'),
		'priority' => '150',
		'panel' => 'inner_page_setups'
		));

	//single post page
	$wp_customize->add_setting('single_post_layout',array(
		'default' => 'sidebar-right',
		'sanitize_callback' => 'eightstore_lite_sanitize_page_layouts'
		));

	$wp_customize->add_control( new Eightstore_lite_WP_Customize_ChooseImage_Control($wp_customize,'single_post_layout',array(
		'type' => 'radioimage',
		'label' => __('Single Post Layout', 'eightstore-lite'),
		'description' => __('Choose layout for single post landing webpage', 'eightstore-lite'),
		'section' => 'single_post_settings',
		'choices' => array( 
			'sidebar-left' => $imagepath.'sidebar-left.png',  
			'sidebar-right' => $imagepath.'sidebar-right.png', 
			'sidebar-both' => $imagepath.'sidebar-both.png',
			'sidebar-no' => $imagepath.'sidebar-no.png',
			)
		)));

	$wp_customize->add_setting('eightstore_inner_cta_post',array(
		'default' =>  '0',
		'sanitize_callback'     =>  'eightstore_lite_checkbox_sanitize'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'eightstore_inner_cta_post',array(
		'section'       =>      'single_post_settings',
		'label'         =>      __('Enable Call to Action Section', 'eightstore-lite'),
		'description'         =>      __('Call to Action Section added on Widget Promo 3 on Single Posts', 'eightstore-lite'),
		'type'          =>      'switch',
		'output'        =>      array('Yes', 'No')
		)));

	//Archive Pages
	$wp_customize->add_section('archive_page_settings',array(
		'title' => __('Archive Pages Settings', 'eightstore-lite'),
		'priority' => '150',
		'panel' => 'inner_page_setups'
		));


	//archive pages layout
	$wp_customize->add_setting('archive_page_layout',array(
		'default' => 'sidebar-right',
		'sanitize_callback' => 'eightstore_lite_sanitize_page_layouts'
		));
	
	$wp_customize->add_control( new Eightstore_lite_WP_Customize_ChooseImage_Control($wp_customize,'archive_page_layout',array(
		'type' => 'radioimage',
		'label' => __('Archive Page Layout', 'eightstore-lite'),
		'description' => __('Choose layout for archive pages landing webpage', 'eightstore-lite'),
		'section' => 'archive_page_settings',
		'choices' => array( 
			'sidebar-left' => $imagepath.'sidebar-left.png',  
			'sidebar-right' => $imagepath.'sidebar-right.png', 
			'sidebar-both' => $imagepath.'sidebar-both.png',
			'sidebar-no' => $imagepath.'sidebar-no.png', 
			)
		)));

	//Social Settings panel
	$wp_customize->add_panel('social_setting', array(
		'capabitity' => 'edit_theme_options',
		'priority' => 30,
		'title' => __('Social Links Settings', 'eightstore-lite')
		));

   //social Settings section
	$wp_customize->add_section('social_setting', array(
		'priority' => 10,
		'title' => __('Social Section', 'eightstore-lite'),
		'panel' => 'social_setting',
		));

    //socail setting in header
	$wp_customize->add_setting('social_icons_in_header', array(
		'default' => '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer',
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'social_icons_in_header', array(
		'type' => 'switch',
		'label' => __('Display Social Icons in Header', 'eightstore-lite'),
		'section' => 'social_setting',
		)));

	$wp_customize->add_setting('social_icons_in_footer', array(
		'default' => '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer',
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'social_icons_in_footer', array(
		'type' => 'switch',
		'label' => __('Display Social Icons in Footer', 'eightstore-lite'),
		'section' => 'social_setting',
		)));

   //social facebook link
	$wp_customize->add_setting('social_facebook', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_facebook',array(
		'type' => 'text',
		'label' => __('Facebook','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_facebook'
		));

    //social twitter link
	$wp_customize->add_setting('social_twitter', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_twitter',array(
		'type' => 'text',
		'label' => __('Twitter','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_twitter'
		));

    //social googleplus link
	$wp_customize->add_setting('social_googleplus', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_googleplus',array(
		'type' => 'text',
		'label' => __('Google Plus','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_googleplus'
		));

     //social youtube link
	$wp_customize->add_setting('social_youtube', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_youtube',array(
		'type' => 'text',
		'label' => __('YouTube','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_youtube'
		));

     //social pinterest link
	$wp_customize->add_setting('social_pinterest', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_pinterest',array(
		'type' => 'text',
		'label' => __('Pinterest','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_pinterest'
		));

    //social linkedin link
	$wp_customize->add_setting('social_linkedin', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_linkedin',array(
		'type' => 'text',
		'label' => __('Linkedin','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_linkedin'
		));

    //social vimeo link
	$wp_customize->add_setting('social_vimeo', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_vimeo',array(
		'type' => 'text',
		'label' => __('Vimeo','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_vimeo'
		));

    //social instagram link
	$wp_customize->add_setting('social_instagram', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_instagram',array(
		'type' => 'text',
		'label' => __('Instagram','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_instagram'
		));

    //social skype link
	$wp_customize->add_setting('social_skype', array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('social_skype',array(
		'type' => 'text',
		'label' => __('Skype','eightstore-lite'),
		'section' => 'social_setting',
		'setting' => 'social_skype'
		));

	//Payment Partners logo
	$wp_customize->add_panel('paymentlogo_setting',array(
		'priority' => '40',
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('Payment Partner Logo Setting', 'eightstore-lite' ),
		'description' => __( 'This allows to edit the payment logos', 'eightstore-lite' ),
		));

	$wp_customize->add_section('paymentlogo_images',array(
		'title' => __('Payment Logo Images', 'eightstore-lite'),
		'priority' => '2',
		'panel' => 'paymentlogo_setting',
		));

	$wp_customize->add_setting('paymentlogo1_image',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'paymentlogo1_image',array(
		'type'          =>      'image',
		'label'         =>      __('Upload Payment Logo 1 Image', 'eightstore-lite'),
		'section'       =>      'paymentlogo_images',
		)));

	$wp_customize->add_setting('paymentlogo2_image',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'paymentlogo2_image',array(
		'type' => 'image',
		'label' => __('Upload Payment Logo 2 Image', 'eightstore-lite'),
		'section' => 'paymentlogo_images',
		)));

	$wp_customize->add_setting('paymentlogo3_image',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'paymentlogo3_image',array(
		'type' => 'image',
		'label' => __('Upload Payment Logo 3 Image', 'eightstore-lite'),
		'section' => 'paymentlogo_images',
		)));

	$wp_customize->add_setting('paymentlogo4_image',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'paymentlogo4_image',array(
		'type' => 'image',
		'label' => __('Upload Payment Logo 4 Image', 'eightstore-lite'),
		'section' => 'paymentlogo_images',
		)));

	//SSL adn other Seal images
	$wp_customize->add_section('other_images',array(
		'title' => __('Other Logo Images', 'eightstore-lite'),
		'priority' => '2',
		'panel' => 'paymentlogo_setting',
		));

	$wp_customize->add_setting('other1_image',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'other1_image',array(
		'type' => 'image',
		'label' => __('Upload SSL Seal Image', 'eightstore-lite'),
		'section' => 'other_images',
		))); 

	$wp_customize->add_setting('other2_image',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'other2_image',array(
		'type' => 'image',
		'label' => __('Upload Other Seal 1 Image', 'eightstore-lite'),
		'section' => 'other_images',
		)));

	$wp_customize->add_setting('other3_image',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'other3_image',array(
		'type' => 'image',
		'label' => __('Upload Other Seal 2 Image', 'eightstore-lite'),
		'section' => 'other_images',
		)));

	if(is_woocommerce_available()):
	//Woocommerce custom options
	$wp_customize->add_panel('woocommerce_setting',array(
		'priority' => '50',
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('Woocommerce Setting', 'eightstore-lite' ),
		'description' => __( 'This allows to set wocommerce settings', 'eightstore-lite' ),
		));

	$wp_customize->add_section('woocommerce_section',array(
		'title' => __('Woocommerce Options', 'eightstore-lite'),
		'priority' => '2',
		'panel' => 'woocommerce_setting',
		));

	$wp_customize->add_setting('wc_custom_placeholder',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
		));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'wc_custom_placeholder',array(
		'type' => 'image',
		'label'         =>      __('Upload Custom Placeholder', 'eightstore-lite'),
		'section'       =>      'woocommerce_section',
		)));
	$wp_customize->add_section('wc_products_shop',array(
		'title' => __('Products In Shop', 'eightstore-lite'),
		'priority' => '2',
		'panel' => 'woocommerce_setting',
		));

	$wp_customize->add_setting('wc_product_number_rows',array(
		'default' => '4',
		'sanitize_callback' => 'eightstore_lite_eightstore_lite_sanitize_integer_product_rows'
		));

	$wp_customize->add_control('wc_product_number_rows',array(
		'type' => 'number',
		'label' => __('Number of Products In a Row', 'eightstore-lite'),
		'description' => __('Enter number of products to be shown in one row of shop (Max Value 5. Values Greater than 5 will be treated as 5)', 'eightstore-lite'),
		'section' => 'wc_products_shop',
		));
	$wp_customize->add_setting('wc_product_number_total',array(
		'default' => '12',
		'sanitize_callback' => 'eightstore_lite_sanitize_integer',
		));

	$wp_customize->add_control('wc_product_number_total',array(
		'type' => 'number',
		'label' => __('Number of Products', 'eightstore-lite'),
		'description' => __('Enter number of products to be shown in one page of shop <br /><strong> This will only work after saving and reloading the page</strong>.', 'eightstore-lite'),
		'section' => 'wc_products_shop',
		));

	$wp_customize->add_section('woocommerce_shop_pages',array(
		'title' => __('Woocommerce Shop Pages', 'eightstore-lite'),
		'priority' => '2',
		'panel' => 'woocommerce_setting',
		));

	$wp_customize->add_setting('eightstore_shop_slider',array(
		'default' =>  '0',
		'sanitize_callback'     =>  'eightstore_lite_checkbox_sanitize'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'eightstore_shop_slider',array(
		'section'       =>      'woocommerce_shop_pages',
		'label'         =>      __('Enable Slider Section', 'eightstore-lite'),
		'description'         =>      __('Slider Section added on Shop Pages', 'eightstore-lite'),
		'type'          =>      'switch',
		'output'        =>      array('Yes', 'No')
		)));

	$wp_customize->add_setting('eightstore_shop_cta',array(
		'default' =>  '0',
		'sanitize_callback'     =>  'eightstore_lite_checkbox_sanitize'
		));

	$wp_customize->add_control(new Eightstore_lite_WP_Customize_Switch_Control($wp_customize,'eightstore_shop_cta',array(
		'section'       =>      'woocommerce_shop_pages',
		'label'         =>      __('Enable Call to Action Section', 'eightstore-lite'),
		'description'         =>      __('Call to Action Section added on Widget Promo 2 on Shop Pages', 'eightstore-lite'),
		'type'          =>      'switch',
		'output'        =>      array('Yes', 'No')
		)));

	endif;

	//Typography settings
	$wp_customize->add_panel( 'typography_panel',array(
		'priority' => 30,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'description' => 'Choose color and fonts/typography settings.',
		'title' => __( 'Typography Settings','eightstore-lite' ),
		));
	
    //typogarphy settings
	$wp_customize->add_section( 'eightstore_lite_typography_option' , array(
		'title'       => __('Typography Options','eightstore-lite'),
		'priority'    => 20,
		'panel' => 'typography_panel',
		) );
	
    //heading typography   
	$wp_customize->add_setting('heading_typography',array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( new Eightstore_lite_Typography_Dropdown( $wp_customize ,'heading_typography',array(
		'label' => __('<h3>Choose Fonts for Heading Text.</h3>','eightstore-lite'),
		'section' => 'eightstore_lite_typography_option',
		'description' => __('Choose a font for the heading H1, H2, H3, H4, H5, H6 text','eightstore-lite'),
		'type' => 'select',
		)));

     //heading typography   
	$wp_customize->add_setting('body_typography',array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( new Eightstore_lite_Typography_Dropdown( $wp_customize ,'body_typography',array(
		'label' => __('<h3>Choose Fonts for Body Text.</h3>','eightstore-lite'),
		'section' => 'eightstore_lite_typography_option',
		'description' => __('Choose fonts for body text.','eightstore-lite'),
		'type' => 'select',
		)));

     //typography formating
	$wp_customize->add_section( 'eightstore_lite_typography_format' , array(
		'title'       => __('Typography Formating','eightstore-lite'),
		'priority'    => 20,
		'panel' => 'typography_panel',
		));
	
  //body fonts size
	$wp_customize->add_setting('typography_size_body',array(
		'default' => '14',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( 'typography_size_body',array(
		'label' => __('Body Fonts Size.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		'type' => 'number',
		));

     //body color
	$wp_customize->add_setting('typography_color_body',array(
		'default' => '#000000',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize , 'typography_color_body',array(
		'label' => __('Choose Body Text Color.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		)));

    //heading typography formating h1  
	$wp_customize->add_setting('typography_format_h1',array(
		'default' => '26',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control('typography_format_h1',array(
		'label' => __('Choose Fonts Size for H1 Text.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		'type' => 'number',
		));

  //text color h1
	$wp_customize->add_setting('typography_color_h1',array(
		'default' => '#000000',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize , 'typography_color_h1',array(
		'label' => __('Choose H1 Text Color.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		)));

     //heading typography formating h2  
	$wp_customize->add_setting('typography_format_h2',array(
		'default' => '24',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control('typography_format_h2',array(
		'label' => __('Choose Fonts Size for H2 Text.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		'type' => 'number',
		));

//text color h2
	$wp_customize->add_setting('typography_color_h2',array(
		'default' => '#000000',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize , 'typography_color_h2',array(
		'label' => __('Choose H2 Text Color.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		)));

     //heading typography formating h13  
	$wp_customize->add_setting('typography_format_h3',array(
		'default' => '22',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control('typography_format_h3',array(
		'label' => __('Choose Fonts Size for H3 Text.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		'type' => 'number',
		));
	
 //text color h3
	$wp_customize->add_setting('typography_color_h3',array(
		'default' => '#000000',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize , 'typography_color_h3',array(
		'label' => __('Choose H3 Text Color.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		)));

     //heading typography formating h4  
	$wp_customize->add_setting('typography_format_h4',array(
		'default' => '20',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control('typography_format_h4',array(
		'label' => __('Choose Fonts Size for H4 Text.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		'type' => 'number',
		));

 //text color h4
	$wp_customize->add_setting('typography_color_h4',array(
		'default' => '#000000',
		'transport' => 'postMessage',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));
	
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize , 'typography_color_h4',array(
		'label' => __('Choose H4 Text Color.','eightstore-lite'),
		'section' => 'eightstore_lite_typography_format',
		)));


	//Custom Css Js Tools Section
	$wp_customize->add_section( 'eightstore_lite_custom_tools' , array(
		'title'       => __('Custom Tools','eightstore-lite'),
		'priority'    => 220,
		) );

  	//custom css
	$wp_customize->add_setting('eightstore_lite_custom_tools_css',array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('eightstore_lite_custom_tools_css',array(
		'type' => 'textarea',
		'label' => __('Custom Css','eightstore-lite'),
		'section' => 'eightstore_lite_custom_tools',
		));

  	//custom js
	$wp_customize->add_setting('eightstore_lite_custom_tools_js',array(
		'default' => '',
		'sanitize_callback' => 'eightstore_lite_sanitize_text',
		));

	$wp_customize->add_control('eightstore_lite_custom_tools_js',array(
		'type' => 'textarea',
		'label' => __('Custom Js','eightstore-lite'),
		'section' => 'eightstore_lite_custom_tools',
		));
}
add_action( 'customize_register', 'eightstore_lite_custom_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function eightstore_lite_custom_customize_preview_js() {
	wp_enqueue_script( 'eightstore_lite_custom_customizer', get_template_directory_uri() . '/js/eightstore-customizer.js', array( 'customize-preview' ), '20150611', true );
}
add_action( 'customize_preview_init', 'eightstore_lite_custom_customize_preview_js' );