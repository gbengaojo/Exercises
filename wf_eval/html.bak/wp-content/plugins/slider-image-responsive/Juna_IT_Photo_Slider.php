<?php
/*
	Plugin Name: Juna-IT Slider
	Plugin URI: http://juna-it.com/index.php/photo-slider/
	Description: This Photo Slider plugin easy to use. It Helps you to create and show your images in your web-page how you designed it.
	Version: 1.0.5
	Author: Juna-IT
	Author URI: http://juna-it.com/
	License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

	add_action('widgets_init', function() {
	 	register_widget('Juna_Photo_Slider');
	});
	require_once('Juna_IT_Photo_Slider_Widget.php');
	require_once('Juna_IT_Photo_Slider_Ajax.php');
	require_once('Juna_IT_Photo_Slider_Shortcode.php');

	add_action('wp_enqueue_scripts','Juna_IT_Photo_Slider_Style');

	function Juna_IT_Photo_Slider_Style()
	{
		wp_register_style( 'Juna_IT_Photo_Slider', plugins_url( 'Style/Juna_IT_Photo_Slider_Widget.css',__FILE__ ) );
		wp_register_style( 'fontawesome-css', plugins_url('/Style/junaiticons.css', __FILE__) ); 
	    wp_enqueue_style( 'fontawesome-css' );
	   
		wp_enqueue_style( 'Juna_IT_Photo_Slider' );	

		wp_register_script('Juna_IT_Photo_Slider',plugins_url('Scripts/Juna_IT_Photo_Slider_Widget.js',__FILE__),array('jquery','jquery-ui-core'));
		wp_localize_script('Juna_IT_Photo_Slider', 'object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script('cwp-main', plugins_url('/Scripts/jssor.slider.mini.js', __FILE__), array('jquery', 'jquery-ui-core'));
		wp_enqueue_script( 'Juna_IT_Photo_Slider' );
	}

	add_action("admin_menu", 'Juna_IT_Photo_Slider_Admin_Menu' );

	function Juna_IT_Photo_Slider_Admin_Menu() 
	{
		add_menu_page('Juna_IT_Photo_Slider_Admin_Menu','Photo Slider','manage_options','Juna_IT_Photo_Slider_Admin_Menu','Manage_Juna_IT_Photo_Slider_Admin_Menu','http://juna-it.com/image/photo-slider/photo-slider-admin.png');

 		add_submenu_page( 'Juna_IT_Photo_Slider_Admin_Menu', 'Juna_IT_Photo_Slider_Admin_Menu_page_1', 'Slider Manager', 'manage_options', 'Juna_IT_Photo_Slider_Admin_Menu', 'Manage_Juna_IT_Photo_Slider_Admin_Menu');
		add_submenu_page( 'Juna_IT_Photo_Slider_Admin_Menu', 'Juna_IT_Photo_Slider_Admin_Menu_page_3', 'General Options', 'manage_options', 'Juna_IT_Photo_Slider_Admin_Menu_General_Options', 'Manage_Juna_IT_Photo_Slider_Admin_Menu_submenu_3');

	}
	function Manage_Juna_IT_Photo_Slider_Admin_Menu()
	{
		require_once('Juna_IT_Photo_Slider_Admin_Menu.php');
		require_once('Scripts/Juna_IT_Photo_Slider_Submenu1.js.php');
		require_once('Style/Juna_IT_Photo_Slider_Submenu1.css.php');
	}
	function Manage_Juna_IT_Photo_Slider_Admin_Menu_submenu_3()
	{
		require_once('Juna_IT_Photo_Slider_Admin_Menu_General_Options.php');
		require_once('Scripts/Juna_IT_Photo_Slider_Submenu3.js.php');
		require_once('Style/Juna_IT_Photo_Slider_Submenu3.css.php');
	}
	
	add_action('admin_init', function() {

		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');

		wp_register_script('Juna_IT_Photo_Slider', plugins_url('Scripts/Juna_IT_Photo_Slider_Admin.js',__FILE__),array('jquery','jquery-ui-core'));
		wp_localize_script('Juna_IT_Photo_Slider', 'object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script('Juna_IT_Photo_Slider');

		wp_register_style('Juna_IT_Photo_Slider', plugins_url('Style/Juna_IT_Photo_Slider_Admin_Style.css', __FILE__ ));
		wp_enqueue_style('Juna_IT_Photo_Slider');	
		wp_register_style( 'fontawesome-css', plugins_url('/Style/junaiticons.css', __FILE__) ); 
	    wp_enqueue_style( 'fontawesome-css' );	 
	});

	register_activation_hook(__FILE__,'Juna_IT_Photo_Slider_wp_activate');

	function Juna_IT_Photo_Slider_wp_activate()
	{
		require_once('Juna_IT_Photo_Slider_Install.php');
	}
?>