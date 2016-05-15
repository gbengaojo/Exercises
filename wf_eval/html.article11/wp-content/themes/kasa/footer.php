<?php
/**
 * The template for displaying the footer.
 *
 *
 * @package Kasa
 */
?>
         <footer id="footer">
			<div class="container">
				<div class="columnwrapp clearfix">
					<div class="column4">
						<div class="gutter">
							<?php if ( is_active_sidebar('footer-widget-area-1') ) : ?>
							<?php dynamic_sidebar('footer-widget-area-1'); ?>
							<?php else : ?>	
								<aside class="widget">
									<h3 class="widget-title"><?php _e( 'Recent Posts', "kasa" ); ?></h3>
									<ul>
										<?php wp_get_archives('type=postbypost&limit=10'); ?>
									</ul>
								</aside>
							<?php endif; ?>
						</div>
					</div>
					<div class="column4">
						<div class="gutter">
							<?php if ( is_active_sidebar('footer-widget-area-2') ) : ?>
							<?php dynamic_sidebar('footer-widget-area-2'); ?>
							<?php else : ?>	
								<aside class="widget">
									<h3 class="widget-title"><?php _e( 'Tag Cloud', "kasa" ); ?></h3>
									<div class="tagcloud">
										<?php wp_tag_cloud(); ?>
									</div>
								</aside>
							<?php endif; ?>
						</div>
					</div>
					<div class="column4">
						<div class="gutter">
							<?php if ( is_active_sidebar('footer-widget-area-3') ) : ?>
							<?php dynamic_sidebar('footer-widget-area-3'); ?>
							<?php else : ?>	
								<aside class="widget">
									<h3 class="widget-title"><?php _e( 'Pages', "kasa" ); ?></h3>
									<ul>
										<?php wp_list_pages('title_li='); ?>
									</ul>
								</aside>
							<?php endif; ?>
						</div>
					</div>
					<div class="column4">
						<div class="gutter">
							<?php if ( is_active_sidebar('footer-widget-area-4') ) : ?>
							<?php dynamic_sidebar('footer-widget-area-4'); ?>
							<?php else : ?>	
								<aside class="widget">
									<h3 class="widget-title"><?php _e( 'Categories', "kasa" ); ?></h3>
									<ul>
										<?php wp_list_categories('title_li='); ?>
									</ul>
								</aside>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="copyright_block gutter clearfix">
					<ul class="menufooter">
						<li><?php do_action( 'kasa_display_credits' ); ?></li>
					</ul>
					<p class="copyright"><?php  echo esc_html(of_get_option('footer_text_left')); ?></p>
				</div>
			</div>
		</footer>
	</div>
<?php wp_footer(); ?>		
</body>
</html>