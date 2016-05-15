<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @subpackage fCorpo
 * @author tishonator
 * @since fCorpo 1.0.0
 *
 */

 get_header();

 if ( is_front_page() ) :

 	fcorpo_display_slider();

 endif;

 ?>

<div id="main-content-wrapper">

	<div id="main-content">

	<?php if ( have_posts() ) :
			
			while ( have_posts() ) :
			
				the_post();

				// includes the single page content templata here
				get_template_part( 'template-parts/content', 'page' );

				// if comments are open or there's at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			
			endwhile;
			
			wp_link_pages( array(
							'link_before'      => '<li>',
							'link_after'       => '</li>',
						 ) );
				
		  else : 
		  
			// if no content is loaded, show the 'no found' template
			get_template_part( 'template-parts/content', 'none' );
	 
		  endif; ?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>