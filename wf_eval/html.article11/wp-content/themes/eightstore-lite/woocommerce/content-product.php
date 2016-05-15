<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
    return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
    $classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
    $classes[] = 'last';
}
$classes[] = "item-prod-wrap wow flipInY";
?>
<li <?php post_class($classes); ?> data-wow-delay="0.5s">
	<?php do_action('woocommerce_before_shop_loop_item'); ?>
	<div class="collection_combine item-img">
		<a href="<?php the_permalink(); ?>" class="full-outer">
			<?php
            /**
             * woocommerce_before_shop_loop_item_title hook
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>
        </a>
        <?php
        if (function_exists('YITH_WCWL')) {
        	$url = add_query_arg('add_to_wishlist', $product->id);
        	?>
        	<a class="item-wishlist" href="<?php echo $url ?>"><i class="fa fa-heart-o"><span>Whishlist</span></i></a>
        	<?php
        }
        ?>
    </div>
    <div class="collection_desc clearfix">
    	<div class="title-cart">
    		<a href="<?php the_permalink(); ?>" class="collection_title">
    			<h3><?php the_title(); ?></h3>
    		</a>
    		<div class="cart">
    			<?php
            /**
             * woocommerce_after_shop_loop_item hook
             *
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action('woocommerce_after_shop_loop_item');
            ?>
        </div>
    </div>
    <div class="price-desc">
    	<?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            ?>
        </div>
    </div>
</li>
<?php if (0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns']) { ?>
<li class='space clearfix'></li>
<?php } ?>

