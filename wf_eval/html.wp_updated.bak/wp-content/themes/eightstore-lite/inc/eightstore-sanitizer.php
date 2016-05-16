<?php
/**
* Custom Sanitizer Function 
*/

function eightstore_lite_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function eightstore_lite_sanitize_integer_product_rows($input) {
	if($input>5){
		$input=5;	
	}
	return intval( $input );
}

function eightstore_lite_sanitize_integer($input) {
	return intval( $input );
}

function eightstore_lite_sanitize_radio_webpagelayout($input) {
	$valid_keys = array(
		'boxed' => __('Boxed', 'eightstore-lite'),
		'fullwidth' => __('Full Width', 'eightstore-lite')
		);
	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}
function eightstore_lite_sanitize_transition_type($input){
	$valid_keys = array(
		'true' => __('Fade', 'eightstore-lite'),
		'false' => __('Slide', 'eightstore-lite'),
		);
	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}
function eightstore_lite_sanitize_page_layouts($input) {
	$imagepath =  get_template_directory_uri() . '/inc/images/';
	$valid_keys = array(
		'sidebar-left' => $imagepath.'sidebar-left.png',  
		'sidebar-right' => $imagepath.'sidebar-right.png', 
		'sidebar-both' => $imagepath.'sidebar-both.png',
		'sidebar-no' => $imagepath.'sidebar-no.png',
		);
	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}

// checkbox sanitization
   function eightstore_lite_checkbox_sanitize($input) {
      if ( $input == 1 ) {
         return 1;
      } else {
         return '';
      }
   }