<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Kasa
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="header">
			<div class="container">
				<div class="gutter clearfix">
					<?php if ( of_get_option('logo_image') ) { ?>
					   <a class="logo" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(of_get_option('logo_image')); ?>" /></a>
					<?php } else if (of_get_option('header_logo_text1')){  ?>
					    <a class="logo" href="<?php echo esc_url(home_url('/')); ?>"><span class="color_orange"><?php echo esc_html(of_get_option('header_logo_text1')); ?></span> <?php echo esc_html(of_get_option('header_logo_text2')); ?> <span class="italic"><?php bloginfo('description'); ?></span></a>
					<?php } else {  ?>
						<a class="logo" href="<?php echo esc_url(home_url('/')); ?>"><span class="color_orange"><?php bloginfo('name'); ?></span><span class="italic"><?php bloginfo('description'); ?></span></a>
					<?php } ?>
					<?php if ( of_get_option('header_phone') ) { ?><p class="callnr"><span><?php echo esc_html(of_get_option('header_phone')); ?></span></p><?php } ?>
					<div class="clear"></div>
					<nav class="menucontainer clearfix">
						<?php if ( has_nav_menu( 'primary' ) ) { ?>
						   <?php wp_nav_menu( array('container'=> '', 'theme_location' => 'primary', 'items_wrap'  => '<ul class="menutop">%3$s</ul>'  ) ); ?>
						<?php } else { ?>
							<?php wp_nav_menu(  array( 'menu_class'  => 'menutop') ); ?>	
						<?php } ?>
						
						<a class="menuicon" href="#" ><?php _e( 'Menu', 'kasa' ); ?></a>
						<?php if ( has_nav_menu( 'primary' ) ) { ?>
						   <?php wp_nav_menu( array('container'=> '', 'theme_location' => 'primary', 'items_wrap'  => '<ul class="menutopmob">%3$s</ul>'  ) ); ?>
						<?php } else { ?>
							<?php wp_nav_menu(  array( 'menu_class'  => 'menutopmob' ) ); ?>	
						<?php } ?>
					</nav>
				</div>
			</div>
		</header>