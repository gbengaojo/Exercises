<?php 
/**
 * 
 * @package Kasa 
 */
get_header(); 
if ( have_posts() ) : 
if ( 'posts' == get_option( 'show_on_front' ) ) {
?>
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
							while ( have_posts() ) : the_post(); 
										get_template_part( 'content', 'posts');          
						    endwhile; 
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
<?php } else { ?>		
        <?php 
		while ( have_posts() ) : the_post(); 
		    get_template_part( 'content', 'home' );
        endwhile; 
        ?>
<?php } 
endif; 
 get_footer(); ?>