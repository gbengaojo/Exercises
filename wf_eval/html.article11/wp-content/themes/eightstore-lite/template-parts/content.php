<?php
/**
 * Template part for displaying posts.
 *
 * @package 8Store Lite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php eightstore_lite_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php if(has_post_thumbnail()): ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink();?>">
				<?php the_post_thumbnail('full'); ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		// the_content( sprintf(
		// 	wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'eightstore-lite' ), array( 'span' => array( 'class' => array() ) ) ),
		// 	the_title( '<span class="screen-reader-text">"', '"</span>', false )
		// 	) );

		?>
		<?php echo eightstore_lite_excerpt(get_the_content(), 1000); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eightstore-lite' ),
			'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
		<a class="read-more" href="<?php the_permalink();?>"><?php echo __('Read More','eightstore-lite');?>

			<footer class="entry-footer">
				<?php eightstore_lite_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</article><!-- #post-## -->
