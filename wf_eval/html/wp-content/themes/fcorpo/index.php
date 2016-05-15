<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @subpackage fCorpo
 * @author tishonator
 * @since fCorpo 1.0.0
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

 get_header();

 if ( is_home() ) :

 	fcorpo_display_slider();

 endif;
 
?>

 <div class="clear">
</div><!-- .clear -->

<div id="main-content-wrapper">

	<div id="main-content">

	<?php if ( have_posts() ) : 

				// starts the loop
				while ( have_posts() ) :

					the_post();

					/*
					 * Include the post format-specific template for the content.
					 */
					get_template_part( 'template-parts/content', get_post_format() );

				endwhile;
	?>
				<div class="navigation">
					<?php echo paginate_links( array( 'prev_next' => '', ) ); ?>
				</div><!-- #navigation -->

	<?php else :

				// if no content is loaded, show the 'no found' template
				get_template_part( 'template-parts/content', 'none' );
			
		  endif; ?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>