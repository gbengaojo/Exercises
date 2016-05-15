<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @package WordPress
 * @subpackage fCorpo
 * @author tishonator
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since fCorpo 1.0.0
 *
 */

get_header(); ?>

<div id="main-content-wrapper">
	<div id="main-content">
	<?php if ( have_posts() ) : ?>

				<?php
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
				</div><!-- .navigation --> 
	<?php else :

				// if no content is loaded, show the 'no found' template
				get_template_part( 'template-parts/content', 'none' );
			
		  endif; ?>
	</div><!-- #main-content -->

	<?php get_sidebar(); ?>
</div><!-- #main-content-wrapper -->
<?php get_footer(); ?>