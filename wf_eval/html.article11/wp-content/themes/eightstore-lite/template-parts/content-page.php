<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package 8Store Lite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
			<?php edit_post_link( esc_html__( 'Edit', 'eightstore-lite' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->

