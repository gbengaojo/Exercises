<?php
/**
 * The template for displaying all single posts.
 *
 * @package 8Store Lite
 */

get_header(); 
global $post;
//wp_reset_query();
$single_post_layout = get_post_meta($post->ID, 'eightstore_lite_post_sidebar_layout', true);
if (empty($single_post_layout)) {
	$single_post_layout = esc_attr(get_theme_mod('single_post_layout','sidebar-right'));
}
?>
<div class="store-wrapper">
	<main id="main" class="site-main clearfix <?php echo esc_attr($single_post_layout); ?>" role="main">
		<?php if ($single_post_layout == 'sidebar-both'): ?>
			<div id="primary-wrap" class="clearfix">
			<?php endif; ?>
			<div id="primary" class="content-area">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php the_post_navigation(); ?>

					<?php
				// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // End of the loop. ?>
			</div><!-- #primary -->
			<?php
			if ($single_post_layout == 'sidebar-both' || $single_post_layout == 'sidebar-left'):
				get_sidebar('left');
			endif;
			?>

			<?php if ($single_post_layout == 'sidebar-both'): ?>
			</div>
		<?php endif; ?>

		<?php
		if ($single_post_layout == 'sidebar-both' || $single_post_layout == 'sidebar-right'):
			get_sidebar('right');
		endif;
		?>


	</main><!-- #main -->
</div>
<?php
			//promotional section 3 if enabled for inner pages
if(get_theme_mod('eightstore_inner_cta_post')=="1"){
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
