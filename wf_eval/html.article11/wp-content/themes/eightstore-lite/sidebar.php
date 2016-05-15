<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package 8Store Lite
 */


if ( ! is_active_sidebar( 'sidebar-right' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area  sidebar">
	<?php dynamic_sidebar( 'sidebar-right' ); ?>
</div><!-- #secondary -->

