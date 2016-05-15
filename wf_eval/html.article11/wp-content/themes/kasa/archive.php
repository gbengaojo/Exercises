<?php
/**
 * The template for displaying archive
 *
 *
 * @package Kasa
 */
get_header(); ?>
		<div class="page_title">
			<div class="container">
				<div class="gutter">
					<p><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'kasa' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'kasa' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'kasa' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'kasa' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'kasa' ) ) . '</span>' );
					else :
						_e( 'Archives', 'kasa' );
					endif;
				    ?></p>
				</div>
			</div>
		</div> <!--  END page_title  -->
		<div id="content">
			<div class="container">
				<div class="sidebar_right clearfix">
					<section class="pagesection">
						<div class="gutter">
							 <?php while (have_posts()) : the_post(); ?>
							 <?php get_template_part( 'content', 'posts');  ?>								
							 <?php endwhile; ?>	
								<p class="simplepag">
									<span class="prev"><?php next_posts_link(__('Previous Posts', 'kasa')) ?></span>
									<span class="next"><?php previous_posts_link(__('Next posts', 'kasa')) ?></span>
								</p>
						</div>
					</section>
					<?php  get_sidebar(); ?>
				</div>
			</div>
		</div> 
<?php get_footer(); ?>