<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="secondary" class="widget-area woocommerce secondary-left sidebar">
<?php
dynamic_sidebar( 'shop' ); ?>
</div>
