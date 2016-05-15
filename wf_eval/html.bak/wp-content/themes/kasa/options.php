<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// If using image radio buttons, define a directory path
	$set_year = date('Y');
	$options = array();

	/* General Settings */	
	
	$options[] = array(
		'name' => __('General Settings', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Header Logo Text', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'header_logo_text1',
		'std' => '',
		'class' => 'mini', 
		'type' => 'text');	

	$options[] = array(
		'name' => __('Header Logo Text 2', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'header_logo_text2',
		'std' => '',
		'class' => 'mini', 
		'type' => 'text');			
		
	$options[] = array(
		'name' => __('Header Logo Image', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'logo_image',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Fav Icon URL', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'fav_icon',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Web Clip Icon URL', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'web_clip',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Header Phone', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'header_phone',
		'std' => '',
		'class' => 'mini', 
		'type' => 'text');			
		
	$options[] = array(
		'name' => __('Footer copyright text left', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'footer_text_left',
		'std' => 'Copyright &copy; '.$set_year.' '.get_bloginfo('name'),
		'type' => 'text');
			
	$options[] = array(
		'name' => __('Enter your custom CSS styles.', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'custom_css_styles',
		'std' => '',
		'type' => 'textarea');		

	$options[] = array(
		'name' => __('Home Page', 'options_framework_theme'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Top Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 1000 X 390', 'options_framework_theme'),
		'id' => 'top_image',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Slogan Home Page', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'slogan_home_page',
		'type' => 'editor');

	$options[] = array(
		'name' => __('Top Box 1 Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 318 X 96', 'options_framework_theme'),
		'id' => 'top_box_1_image',
		'type' => 'upload');	
		
	$options[] = array(
		'name' => __('Top Box 1 Icon', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_1_icon',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Top Box 1 Icon Hover', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_1_icon_hover',
		'type' => 'upload');		
		
	$options[] = array(
		'name' => __('Top Box 1 Title', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_1_title',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Top Box 1 Link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_1_link',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Top Box 1 Content', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_1_content',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Top Box 2 Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 318 X 96', 'options_framework_theme'),
		'id' => 'top_box_2_image',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Top Box 2 Icon', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_2_icon',
		'type' => 'upload');	

	$options[] = array(
		'name' => __('Top Box 2 Icon Hover', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_2_icon_hover',
		'type' => 'upload');			
		
	$options[] = array(
		'name' => __('Top Box 2 Title', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_2_title',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Top Box 2 Link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_2_link',
		'type' => 'text');			
		
	$options[] = array(
		'name' => __('Top Box 2 Content', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_2_content',
		'type' => 'textarea');	

	$options[] = array(
		'name' => __('Top Box 3 Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 318 X 96', 'options_framework_theme'),
		'id' => 'top_box_3_image',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Top Box 3 Icon', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_3_icon',
		'type' => 'upload');		

	$options[] = array(
		'name' => __('Top Box 3 Icon Hover', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_3_icon_hover',
		'type' => 'upload');			
		
	$options[] = array(
		'name' => __('Top Box 3 Title', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_3_title',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Top Box 3 Link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_3_link',
		'type' => 'text');		
		
	$options[] = array(
		'name' => __('Top Box 3 Content', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'top_box_3_content',
		'type' => 'textarea');				

		
	$options[] = array(
		'name' => __('Title Area 2', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'title_area_2',
		'std' => 'The Lastest Works',
		'type' => 'text');			
		
	$options[] = array(
		'name' => __('Box 1 Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 231 X 208', 'options_framework_theme'),
		'id' => 'box_1_image',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Box 1  Link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'box_1_link',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Box 2 Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 231 X 208', 'options_framework_theme'),
		'id' => 'box_2_image',
		'type' => 'upload');		

	$options[] = array(
		'name' => __('Box 2  Link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'box_2_link',
		'type' => 'text');		
		
	$options[] = array(
		'name' => __('Box 3 Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 231 X 208', 'options_framework_theme'),
		'id' => 'box_3_image',
		'type' => 'upload');			
		
	$options[] = array(
		'name' => __('Box 3  Link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'box_3_link',
		'type' => 'text');			

	$options[] = array(
		'name' => __('Box 4 Image', 'options_framework_theme'),
		'desc' => __('Recommended image sizes 231 X 208', 'options_framework_theme'),
		'id' => 'box_4_image',
		'type' => 'upload');			
		
	$options[] = array(
		'name' => __('Box 4  Link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'box_4_link',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Title Area 3', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'title_area_3',
		'std' => 'Customer Testimonial',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Box Text', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'box_text',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Box Name', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'box_name',
		'type' => 'text');
		
	return $options;
}