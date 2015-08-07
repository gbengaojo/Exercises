<?php
/*
Plugin Name: Prime
Plugin URI: http://www.lucidmediaconcepts.com
Description: Wordfence job application question - Determines the primality of a number using the sieve of Eratosthenes
Version: 1.1
Author: Gbenga Ojo
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
   echo 'Bad request';
   exit;
}

define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(PLUGIN_DIR . 'Primality.php');

/**
 * sieve input form
 */
function primality_input() {
   echo '<h3>Sieve of Eratosthenes</h3>';
   echo '<form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">';
   echo '<input type="text" name="candidate" pattern="[0-9]+" value="">';
   echo '<input type="submit" name="submit" value="Prime?">';
   echo '</form>';
}

/**
 * object orientation and db example; run sieve
 */
function test_primality() {
   $primality = new Primality();
   
   $primality->db();

   if (isset($_POST['candidate'])) {
      $candidate = sanitize_text_field($_POST['candidate']);

      if ($primality->isPrime($candidate)) {
         echo 'Prime';
      } else {
         echo 'Not Prime';
      }
   }
}

add_action('admin_notices', 'test_primality');
add_action('admin_notices', 'primality_input');
