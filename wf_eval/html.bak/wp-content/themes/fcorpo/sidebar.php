<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage fCorpo
 * @author tishonator
 * @since fCorpo 1.0.0
 *
 */
?>

<aside id="sidebar">

	<?php
		/**
		 * Display Widgets dragged in the 'Sidebar' Widget Area
		 */
	?>
	<?php if ( !dynamic_sidebar( 'sidebar-widget-area' ) ) : ?>

			<?php
				/**
				 * Add Default Widgets for 'Sidebar Widget Area'
			     * If you want to customize it, log in to your WordPress Admin Panel,
			     * Goto Appearance -> Widgets and drag widgets to 'Sidebar'
		         */
			?>
			<?php
			
				the_widget( 'WP_Widget_Categories', array(), array ('before_title' => '<h3 class="sidebar-title">',
																	'after_title'  => '</h3><div class="sidebar-after-title"></div>') );
			
				the_widget( 'WP_Widget_Archives', array(), array ('before_title' => '<h3 class="sidebar-title">',
																  'after_title'  => '</h3><div class="sidebar-after-title"></div>') );
			?>

	<?php endif; ?>
	
</aside><!-- #sidebar -->