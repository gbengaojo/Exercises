<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package 8Store Lite
 */

get_header(); 
wp_reset_query();
global $post;
$single_page_layout = get_post_meta($post->ID, 'eightstore_lite_sidebar_layout', true);
if (empty($single_page_layout)) {
	$single_page_layout = get_theme_mod('single_page_layout','sidebar-right');
}
if (is_page('cart') || is_page('checkout')) {
	$single_page_layout = "sidebar-no";
}
?>
<div class="store-wrapper">
	<main id="main" class="site-main clearfix <?php echo esc_attr($single_page_layout); ?>" role="main">
		<?php if ($single_page_layout == 'sidebar-both'): ?>
			<div id="primary-wrap" class="clearfix">
			<?php endif; ?>
			<div id="primary" class="content-area">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // End of the loop. ?>
			</div><!-- #primary -->
			<?php
			if ($single_page_layout == 'sidebar-both' || $single_page_layout == 'sidebar-left'){
				get_sidebar('left');
			}
			if ($single_page_layout == 'sidebar-both'){ 
				?>
			</div>
			<?php
		}
		if ($single_page_layout == 'sidebar-both' || $single_page_layout == 'sidebar-right'){
			get_sidebar('right');
		}
		?>

	</main><!-- #main -->
</div>
<?php
			//promotional section 3 if enabled for inner pages
if(get_theme_mod('eightstore_inner_cta')=="1"){
			//promotional section 3
	if(is_active_sidebar('widget-promo-3')){
		?>
		<section id="section-promo3" class='clear'>
			<div class="small-cta-block">
				<?php dynamic_sidebar('widget-promo-3'); ?>
			</div>
		</section>
		<?php
	}
}
?>
<?php get_footer(); ?>
