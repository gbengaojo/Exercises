<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<?php
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}
if(isset($woocommerce_loop['columns'])){
	$cols = $woocommerce_loop['columns'];
}else{
	$cols='3';
}
?>
<ul class="products columns-<?php echo $cols; ?>">