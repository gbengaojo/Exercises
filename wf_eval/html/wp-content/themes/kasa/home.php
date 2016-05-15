<?php 
/**
 * Template Name: Blog
 * 
 * @package Kasa 
 */
get_header(); ?>
		<div class="page_title">
			<div class="container">
				<div class="gutter">
					<p><?php the_title(); ?></p>
				</div>
			</div>
		</div>
		<div id="content">
			<div class="container">
				<div class="sidebar_right clearfix">
					<section class="pagesection">
						<div class="gutter">
						    <?php 
							$list_posts = kasa_get_list_posts();
							while ( $list_posts->have_posts() ) {
								$list_posts->the_post();
								get_template_part( 'content', 'posts'); 								
							} 
							?>
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