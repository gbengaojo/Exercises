<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Kasa
 */
?>
<div class="pagesidebar">
	<div class="gutter">
		<?php if ( is_active_sidebar('sidebar-widget-area') ) : ?>
			<?php dynamic_sidebar('sidebar-widget-area'); ?>
		<?php else : ?>	
			<aside class="widget">
				<h3 class="widget-title"><?php _e( 'Recent Posts', "kasa" ); ?></h3>
				<ul>
					<?php wp_get_archives('type=postbypost&limit=10'); ?>
				</ul>
			</aside>
			<aside class="widget">
				<h3 class="widget-title"><?php _e( 'Pages', "kasa" ); ?></h3>
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
			</aside>
			<aside class="widget">
				<h3 class="widget-title"><?php _e( 'Tag Cloud', "kasa" ); ?></h3>
				<div class="tagcloud">
					<?php wp_tag_cloud(); ?>
				</div>
			</aside>
			<aside class="widget">
				<h3 class="widget-title"><?php _e( 'Categories', "kasa" ); ?></h3>
				<ul>
					<?php wp_list_categories('title_li='); ?>
				</ul>
			</aside>		
		<?php endif; ?>
	</div>
</div>


