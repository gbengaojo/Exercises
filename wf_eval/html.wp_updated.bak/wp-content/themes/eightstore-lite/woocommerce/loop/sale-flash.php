<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><img src="'.get_template_directory_uri().'/images/sale-icon.png" alt="' . __( 'Sale!', 'eightstore-lite' ) . '"/></span>', $post, $product ); ?>

<?php endif; ?>
