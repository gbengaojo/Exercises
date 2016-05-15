<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Template Name: Home 
 * @package 8Store Lite
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		//load slider
		do_action('eightstore_lite_homepage_slider'); 
		
		//block below slider
		$eightstore_lite_category_promo_setting_category = get_theme_mod('es_category_promo_setting_category');
		if(!empty($eightstore_lite_category_promo_setting_category)){
			?>
			<section id="section-below-slider" class="clear">
				<div class="store-wrapper">
					<?php
					$loop = new WP_Query(array(
						'cat' => $eightstore_lite_category_promo_setting_category,
						'posts_per_page' => 4,
						'order' => 'ASC' 
						));
					if($loop->have_posts()) { 
						$i=1;
						while($loop->have_posts()) {
							$loop-> the_post();
							if($i==1 || $i==4){
								?>
								<div class="block-large">
									<a href="<?php the_permalink(); ?>">
										<?php
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eightstore-promo-large', false );
										?>
										<img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>" />
										<div class="block-title"><?php the_title(); ?></div>
									</a>
								</div>
								<?php 
							}
							else
							{
								if($i==2){ ?><div class="small-wrap"><?php }
									?>
								<div class="block-small">
									<a href="<?php the_permalink(); ?>">
										<?php
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'eightstore-promo-small', false );
										?>
										<img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>" />
										<div class="block-title"><?php the_title(); ?></div>
									</a>
								</div>
								<?php 
								if($i==3){ ?></div><?php }
							}
						$i++;
					}
				}
				wp_reset_postdata();
				?>
			</div>
		</section>
		<?php
	}
	?>
	<?php
		//product section 1
	if(is_active_sidebar('widget-product-1')){
		?>
		<section id="section-product1" class='clear'>
			<div class="store-wrapper">
				<?php dynamic_sidebar('widget-product-1'); ?>
			</div>
		</section>
		<?php
	}
		//promotional section 1
	if(is_active_sidebar('widget-promo-1')){
		?>
		<section id="section-promo1" class='clear'>
			<div class="video-cta">
				<?php dynamic_sidebar('widget-promo-1'); ?>
			</div>
		</section>
		<?php
	}
		//Category + Product section 1
	if(is_active_sidebar('widget-category-1')){
		?>
		<section id="section-category1" class='clear'>
			<div class="store-wrapper">
				<?php dynamic_sidebar('widget-category-1'); ?>
			</div>
		</section>
		<?php
	}
		//promotional section 2
	if(is_active_sidebar('widget-promo-2')){
		?>
		<section id="section-promo2" class='clear'>
			<div class="large-cta-block">
				<?php dynamic_sidebar('widget-promo-2'); ?>
			</div>
		</section>
		<?php
	}
		//Category + Product section 2
	if(is_active_sidebar('widget-category-2')){
		?>
		<section id="section-category2" class='clear'>
			<div class="store-wrapper">
				<?php dynamic_sidebar('widget-category-2'); ?>
			</div>
		</section>
		<?php
	}
	
		//promotional section 3
	if(is_active_sidebar('widget-promo-3')){
		?>
		<section id="section-promo3" class='clear'>
			<div class="small-cta-block">
				<?php dynamic_sidebar('widget-promo-3'); ?>
			</div>
		</section>
		<?php
	}
		//product section 2
	if(is_active_sidebar('widget-product-2')){
		?>
		<section id="section-product2" class='clear'>
			<div class="store-wrapper">
				<?php dynamic_sidebar('widget-product-2'); ?>
				<?php echo do_shortcode(get_theme_mod('eightstore_form_shortcode'));?>
			</div>
		</section>
		<?php
	}
	?>
	<section id="blog-testimonial-section" class="clear<?php if(get_theme_mod('eightstore_blog_section')=='1'){echo " blog-only";} if(get_theme_mod('eightstore_testimonial_section')=='1'){echo " testimonial-only";}?>">
		<div class="store-wrapper">
			<?php
			if(get_theme_mod('eightstore_blog_section')=='1'){
				$wl_blog_cat    =   get_theme_mod('eightstore_blog_setting_category');
				?>
				<?php 
				if($wl_blog_cat!=0):?>

				<section class="blogs" data-wow-delay="0.8s">
					<div class="ed-container">
						<h2 class="home-title wow flipInX"><b><?php echo esc_attr(get_theme_mod('eightstore_blog_title')); ?></b></h2><div class="title-border"></div>
						<div class="blog-wrap wow fadeInRight clearfix">
							<?php
							$blog_args      =   array('cat'=>$wl_blog_cat, 'post_status'=>'publish', 'posts_per_page'=>-1);
							$blog_query     =   new WP_Query($blog_args);
							if($blog_query->have_posts()):
								$j=0;
							while($blog_query->have_posts()):
								$blog_query->the_post();
							$blog_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'eightstore-blog-image', true);
							?>
							<div class="blog-in-wrap <?php if($j%2==0){echo "even";} else{echo "odd";}?>">
								<a href="<?php the_permalink() ?>">
									<div class="blog-image">
										<img src="<?php echo esc_url($blog_image[0]); ?>" alt="<?php the_title_attribute(); ?>" />
									</div>
								</a>
								<div class="blog-content-wrap">
									<div class="blog-title-comment">
										<a href="<?php esc_url(the_permalink()); ?>">
											<div class="blog-single-title"><?php the_title(); ?></div>
										</a>
										<div class="blog-date"><?php echo get_the_date(); ?></div>
										<div class="blog-comment">
											<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
												<span class="comments-link">
													<?php comments_popup_link( __( 'No comment', 'eightstore-lite' ), __( '1 Comment', 'eightstore-lite' ), __( '% Comments', 'eightstore-lite' ) ); ?>
												</span>
											<?php endif; ?>
										</div>
										<a href="<?php echo  esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));  ?>">
											<div class="blog-author">
												<?php echo __('<span>By:</span>', 'eightstore-lite')?> <?php the_author(); ?>
											</div>
										</a>
									</div>
									<div class="blog-content">
										<?php echo eightstore_lite_excerpt(get_the_content(), 120); ?>
										<span><a href="<?php the_permalink() ?>"><?php echo __('Read More','eightstore-lite'); ?></a></span>
									</div>
								</div>
							</div>
							<?php
							$j++;
							endwhile;
							endif;
							?>
						</div>  
					</div>
				</section>
				<?php    
				endif;
				wp_reset_postdata();   
			}

			if(get_theme_mod('eightstore_testimonial_section')=='1'){
				$wl_testimonial_cat    =   get_theme_mod('eightstore_testimonial_setting_category');
				?>
				<?php 
				if($wl_testimonial_cat!=0):?>

				<section class="testimonials" data-wow-delay="0.8s">
					<div class="ed-container">
						<h2 class="home-title wow flipInX"><b><?php echo esc_attr(get_theme_mod('eightstore_testimonial_title')); ?></b></h2><div class="title-border"></div>
						<div class="testimonial-wrap wow fadeInRight clearfix">
							<?php
							$testimonial_args      =   array('cat'=>$wl_testimonial_cat, 'post_status'=>'publish', 'posts_per_page'=>-1);
							$testimonial_query     =   new WP_Query($testimonial_args);
							if($testimonial_query->have_posts()):
								$j=0;
							while($testimonial_query->have_posts()):
								$testimonial_query->the_post();
							$testimonial_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'eightstore-testimonial-image', true);
							?>
							<div class="testimonial-in-wrap <?php if($j%2==0){echo "even";} else{echo "odd";}?>">
								<div class="testimonial-content"><?php echo eightstore_lite_excerpt(get_the_content(), 120); ?>
									<span><a href="<?php the_permalink() ?>"><?php echo __('Read More','eightstore-lite'); ?></a></span>
								</div>
								<div class="testimonial-title-img">
									<a href="<?php the_permalink() ?>">
										<div class="testimonial-image">
											<img src="<?php echo esc_url($testimonial_image[0]); ?>" alt="<?php the_title_attribute(); ?>" />
										</div>
									</a>
									<div class="testimonial-single-title"> 
										<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
										<br /> 
										<?php echo get_the_date(); ?> 
									</div>
								</div>
							</div>
							<?php
							$j++;
							endwhile;
							endif;
							?>
						</div>  
					</div>
				</section>
				<?php    
				endif;
				wp_reset_postdata(); 
			}
			?>
		</div>
	</section>
	<?php

		//promotional section 4
	if(is_active_sidebar('widget-promo-4')){
		?>
		<section id="section-promo4">
			<div class="store-wrapper">
				<?php dynamic_sidebar('widget-promo-4'); ?>
			</div>
		</section>
		<?php
	}

	?>



</main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
