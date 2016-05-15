<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage fCorpo
 * @author tishonator
 * @since fCorpo 1.0.0
 *
 */

 get_header(); ?>

<div id="main-content-wrapper">
	<div id="main-content">
	<?php if (have_posts()) :

			while (have_posts()) :
			
				the_post();
				
				/*
				 * includes a post format-specific template for single content
				 */
				get_template_part( 'template-parts/content', get_post_format() );
				
				// if comments are open or there's at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fcorpo' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );

?>
					<div class="post-links">

						<div class="left">
							<?php previous_post_link(); ?>
						</div><!-- .left -->
						
						<div class="right">
							<?php next_post_link(); ?>
						</div><!-- .right -->

					</div><!-- .post-links -->

		<?php
				
				endwhile;
	?>
	<?php else :

				// if no content is loaded, show the 'no found' template
				get_template_part( 'template-parts/content', 'none' );

		  endif; ?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>