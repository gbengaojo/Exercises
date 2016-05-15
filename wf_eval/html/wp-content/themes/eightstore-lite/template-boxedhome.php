<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Template Name: Boxed HomePage
 * @package 8Store Lite
 */
?>
<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package 8Store Lite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class('boxed home'); ?>>
	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'eightstore-lite' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="top-header">
				<div class="store-wrapper clear">
					<?php
					if ( is_active_sidebar( 'eightstore-lite-language-option' ) ) {
						?>
						<div class="translate-dropdwn">
							<?php
							dynamic_sidebar( 'eightstore-lite-language-option' );
							?>
						</div>
						<?php
					}
					?>
					<?php eightstore_ticker_header_customizer(); ?>
					<div class="header-callto">
						<?php
						//call to section
						$header_callto = get_theme_mod('callto_text');
						?>
						<?php echo $header_callto;?>
						<?php if(get_theme_mod('social_icons_in_header') && get_theme_mod('social_icons_in_header')!='0'){ ?>
						<div class="es-social-header">
							<?php do_action('eightstore_lite_social_links'); ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div><!-- Top Header -->

			<div class="main-header">
				<div class="store-wrapper">
					<div class="site-branding">
						<?php if ( get_header_image() ) : ?>
							<a class="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
							</a>
						<?php endif; // End header image check. ?>
						<div class="site-titles">
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><div class="site-description"><?php bloginfo( 'description' ); ?></div></a>
						</div>
					</div><!-- .site-branding -->
					
					<div class="right-links">
						<!-- if enabled from customizer -->
						<?php if(get_theme_mod('hide_header_search')!='1'){ ?>
						<div class="header-search">
							<a href="javascript:void(0)"><i class="fa fa-search"></i></a>
							<div class="search-box">
								<div class="close"> &times; </div>
								<?php get_search_form(); ?>
							</div>
						</div> <!--  search-form-->
						<?php } ?>

						<div class="my-account">
							<i class="fa fa-unlock-alt"></i>
							<div class="welcome-user">
								<?php
								//if user is logged in
								if(is_user_logged_in()){
									global $current_user;
									get_currentuserinfo();
									?>
									<?php _e('Welcome ', 'eightstore-lite');?>
									<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
										<span class="user-name">
											<?php echo $current_user->display_name; ?>
										</span>
									</a>
									<?php _e('!', 'eightstore-lite');?>
									<a href="<?php echo wp_logout_url(); ?>" class="logout">
										<?php _e('Logout','eightstore-lite'); ?>
									</a>
									<?php
								} else{
									if(is_woocommerce_available()){
										woocommerce_get_template( 'myaccount/form-login.php' );
										?>
										<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="register">
											<?php _e('Register','eightstore-lite'); ?>
										</a>
										<?php
									}else{
										?>
										<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="login">
											<?php _e('Login','eightstore-lite'); ?>
										</a>
										<?php 
									}
								}
								?>
							</div>
						</div>

						<!-- Cart Link -->
						<div class="cart-box">
							<?php 
							if(is_woocommerce_available()):
								echo eightstore_lite_woocommerce_cart_menu();
							endif;
							?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div><!-- Main Header -->
			<div class="store-menu">
				<div class="store-wrapper">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'eightstore-lite' ); ?></button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
					</nav><!-- #site-navigation -->
					<div class="clear"></div>
				</div>
			</div><!-- Main Header -->

		</header><!-- #masthead -->

		<div id="content" class="site-content">


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
										<img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>" />
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
										<img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>" />
										<div class="block-title"><?php the_title(); ?></div>
									</a>
								</div>
								<?php 
								if($i==3){ ?></div><?php }
							}
						$i++;
					}
				}
				wp_reset_query();
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
										<img src="<?php echo esc_url($blog_image[0]); ?>" alt="<?php the_title(); ?>" />
									</div>
								</a>
								<div class="blog-content-wrap">
									<div class="blog-title-comment">
										<a href="<?php the_permalink() ?>">
											<div class="blog-single-title"><?php the_title(); ?></div>
										</a>
										<div class="blog-date"><?php echo get_the_date('d, M Y'); ?></div>
										<div class="blog-comment">
											<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
												<span class="comments-link">
													<?php comments_popup_link( __( 'No comment', 'eightstore-lite' ), __( '1 Comment', 'eightstore-lite' ), __( '% Comments', 'eightstore-lite' ) ); ?>
												</span>
											<?php endif; ?>
										</div>
										<a href="<?php echo  get_author_posts_url( get_the_author_meta( 'ID' ) );  ?>">
											<div class="blog-author">
												<?php echo __('<span>By:</span>', 'eightstore-lite')?> <?php the_author(); ?>
											</div>
										</a>
									</div>
									<div class="blog-content">
										<?php echo eightstore_lite_excerpt(get_the_content(),120,'...',true,true); ?>
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
				wp_reset_query();   
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
											<img src="<?php echo esc_url($testimonial_image[0]); ?>" alt="<?php the_title(); ?>" />
										</div>
									</a>
									<div class="testimonial-single-title"> 
										<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
										<br /> 
										<?php echo get_the_date('d, M Y'); ?> 
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
				wp_reset_query(); 
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
