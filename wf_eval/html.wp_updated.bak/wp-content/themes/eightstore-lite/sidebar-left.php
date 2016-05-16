<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package 8Store Lite
 */

if ( ! is_active_sidebar( 'sidebar-left' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area secondary-left sidebar">
	<?php dynamic_sidebar( 'sidebar-left' ); ?>
</div><!-- #secondary -->
