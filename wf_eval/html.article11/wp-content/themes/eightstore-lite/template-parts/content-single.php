<?php
/**
 * Template part for displaying single posts.
 *
 * @package 8Store Lite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php eightstore_lite_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<?php if(has_post_thumbnail()): ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail('full'); ?>
		</div>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eightstore-lite' ),
			'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php eightstore_lite_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->

