<?php
/**
 * The template for displaying search results pages.
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

		<div id="infoTxt">
			<?php printf( __( 'You searched for "%s". Here are the results:', 'fcorpo' ),
						get_search_query() );
			?>
		</div><!-- #infoTxt -->

	<?php if ( have_posts() ) :

				// starts the loop
				while ( have_posts() ) :

					the_post();

					/*
					 * include the post format-specific template for the content.
					 */
					get_template_part( 'template-parts/content', get_post_format() );

				endwhile;
	?>
				<div class="navigation">
					<?php echo paginate_links( array( 'prev_next' => '', ) ); ?>
				</div><!-- .navigation -->

	<?php else :

				// if no content is loaded, show the 'no found' template
				get_template_part( 'template-parts/content', 'none' );
			
		  endif;
	?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>