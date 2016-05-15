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

<body <?php body_class(); ?>>
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
						<?php echo wp_kses_post($header_callto);?>
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
									<?php _e('Welcome', 'eightstore-lite')." ";?>
									<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>">
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
										woocommerce_login_form();
										?>
										<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" class="register">
											<?php _e('Register','eightstore-lite'); ?>
										</a>
										<?php
									}else{
										?>
										<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" class="login">
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
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( '', 'eightstore-lite' ); ?></button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
					</nav><!-- #site-navigation -->
					<div class="clear"></div>
				</div>
			</div><!-- Main Header -->

		</header><!-- #masthead -->

		<div id="content" class="site-content">
