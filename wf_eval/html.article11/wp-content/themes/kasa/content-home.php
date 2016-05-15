<?php 
/**
 * Template Name: Home Page
 * 
 * @package Kasa 
 */
get_header(); ?>
       <?php if ( of_get_option('top_image') ) { ?>
		<div class="mainbanner_block">
			<div class="container">
				<div class="gutter">
					<ul class="slides">
						<li><img class="fullwidth" src="<?php echo esc_url(of_get_option('top_image')); ?>" /></li>
					</ul>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if ( of_get_option('slogan_home_page') ) { ?>
		<div class="pag_title">
			<div class="container">
				<div class="gutter">
					<p><?php echo of_get_option('slogan_home_page'); ?></p>
				</div>
			</div>
		</div>
		<?php } ?>
    	<div id="content">
			<?php if ( of_get_option('top_box_1_title') or of_get_option('top_box_2_title') or of_get_option('top_box_3_title') ) { ?>
			<div class="container">
				<div class="ourservices_block columnwrapp clearfix">
				    <?php if ( of_get_option('top_box_1_title')) { ?>
					<div class="column3">
						<div class="gutter">
							<a class="servicelink" href="<?php echo esc_url(of_get_option('top_box_1_link')); ?>">
							    <?php if ( of_get_option('top_box_1_icon') ) { ?>
								<span class="icon">
									<img class="default" src="<?php echo esc_url(of_get_option('top_box_1_icon')); ?>" alt="" />
									<img class="hover" src="<?php echo esc_url(of_get_option('top_box_1_icon_hover')); ?>" alt="" />
								</span>
								<?php } ?>
								<?php if ( of_get_option('top_box_1_image') ) { ?><img class="fullwidth" src="<?php echo esc_url(of_get_option('top_box_1_image')); ?>" alt="" /><?php } ?>
								<span class="service_title"><?php echo esc_html(of_get_option('top_box_1_title')); ?></span>
								<span class="inner"><?php echo esc_html(of_get_option('top_box_1_content')); ?></span>
							</a>
						</div>
					</div>
					<?php } ?>
					<?php if ( of_get_option('top_box_2_title')) { ?>
					<div class="column3">
						<div class="gutter">
							<a class="servicelink" href="<?php echo esc_url(of_get_option('top_box_2_link')); ?>">
							    <?php if ( of_get_option('top_box_2_icon') ) { ?>
								<span class="icon">
									<img class="default" src="<?php echo esc_url(of_get_option('top_box_2_icon')); ?>" alt="" />
									<img class="hover" src="<?php echo esc_url(of_get_option('top_box_2_icon_hover')); ?>" alt="" />
								</span>
								<?php } ?>
								<?php if ( of_get_option('top_box_2_image') ) { ?><img class="fullwidth" src="<?php echo esc_url(of_get_option('top_box_2_image')); ?>" alt="" /><?php } ?>
								<span class="service_title"><?php echo esc_html(of_get_option('top_box_2_title')); ?></span>
								<span class="inner"><?php echo esc_html(of_get_option('top_box_2_content')); ?></span>
							</a>
						</div>
					</div>
					<?php } ?>
					<?php if ( of_get_option('top_box_3_title')) { ?>
					<div class="column3">
						<div class="gutter">
							<a class="servicelink" href="<?php echo esc_url(of_get_option('top_box_3_link')); ?>">
							    <?php if ( of_get_option('top_box_3_icon') ) { ?>
								<span class="icon">
									<img class="default" src="<?php echo esc_url(of_get_option('top_box_3_icon')); ?>" alt="" />
									<img class="hover" src="<?php echo esc_url(of_get_option('top_box_3_icon_hover')); ?>" alt="" />
								</span>
								<?php } ?>
								<?php if ( of_get_option('top_box_3_image') ) { ?><img class="fullwidth" src="<?php echo esc_url(of_get_option('top_box_3_image')); ?>" alt="" /><?php } ?>
								<span class="service_title"><?php echo esc_html(of_get_option('top_box_3_title')); ?></span>
								<span class="inner"><?php echo esc_html(of_get_option('top_box_3_content')); ?></span>
							</a>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			<?php if ( of_get_option('title_area_2') ) { ?>
			<div class="portfolio_block">
				<div class="container">
					<div class="gutter">
						<h4><?php echo esc_html(of_get_option('title_area_2')); ?></h4>
					</div>
					<div class="portfolio_slider">
						<ul class="slides">
						    <?php if ( of_get_option('box_1_image') ) { ?>
							<li>
								<div class="gutter">
									<div class="portfolio_item">
										<a href="<?php echo esc_url(of_get_option('box_1_link')); ?>"><img class="fullwidth" src="<?php echo esc_url(of_get_option('box_1_image')); ?>" alt="" /></a>
										<a class="overlay_link" href="<?php echo esc_url(of_get_option('box_1_link')); ?>"></a>
									</div>
								</div>
							</li>
							<?php } ?>
							<?php if ( of_get_option('box_2_image') ) { ?>
							<li>
								<div class="gutter">
									<div class="portfolio_item">
										<a href="<?php echo esc_url(of_get_option('box_2_link')); ?>"><img class="fullwidth" src="<?php echo esc_url(of_get_option('box_2_image')); ?>" alt="" /></a>
										<a class="overlay_link" href="<?php echo esc_url(of_get_option('box_2_link')); ?>"></a>
									</div>
								</div>
							</li>
							<?php } ?>
							<?php if ( of_get_option('box_3_image') ) { ?>
							<li>
								<div class="gutter">
									<div class="portfolio_item">
										<a href="<?php echo esc_url(of_get_option('box_3_link')); ?>"><img class="fullwidth" src="<?php echo esc_url(of_get_option('box_3_image')); ?>" alt="" /></a>
										<a class="overlay_link" href="<?php echo esc_url(of_get_option('box_3_link')); ?>"></a>
									</div>
								</div>
							</li>
							<?php } ?>
							<?php if ( of_get_option('box_4_image') ) { ?>
							<li>
								<div class="gutter">
									<div class="portfolio_item">
										<a href="<?php echo esc_url(of_get_option('box_4_link')); ?>"><img class="fullwidth" src="<?php echo esc_url(of_get_option('box_4_image')); ?>" alt="" /></a>
										<a class="overlay_link" href="<?php echo esc_url(of_get_option('box_4_link')); ?>"></a>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<?php } ?>
			<?php if ( of_get_option('title_area_3') ) { ?>
			<div class="container">
				<div class="gutter">
					<div class="testimonials_block">
						<h4><?php echo esc_html(of_get_option('title_area_3')); ?></h4>
						<ul class="slides">
							<li>
								<p class="testimonial_quote"><?php echo esc_html(of_get_option('box_text')); ?></p>
								<p class="testimonial_author"><?php echo esc_html(of_get_option('box_name')); ?></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
<?php get_footer(); ?>