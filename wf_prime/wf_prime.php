<?php
/*
Plugin Name: Prime
Plugin URI: --
Description: Wordfence job application question
Author: Gbenga Ojo
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
   echo 'Bad request';
   exit;
}

define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(PLUGIN_DIR . 'Prime.php');

add_action('init', array('Prime', 'init'));
