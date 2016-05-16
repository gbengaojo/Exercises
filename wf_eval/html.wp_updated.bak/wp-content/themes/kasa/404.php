<?php
/**
 * The template for displaying all pages.
 *
 * @package Kasa
 */
 get_header(); ?>
 		<div class="page_title">
			<div class="container">
				<div class="gutter">
					<p><?php _e( 'Not found', 'kasa' ); ?></p>
				</div>
			</div>
		</div>
		<div id="content">
			<div class="container">
				<div class="sidebar_right clearfix">
					<section class="pagesection fullwidthpage">
						<div class="gutter">
							<article class="singlepost">
							    <h2><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'kasa' ); ?></h2>
							</article>
						</div>
					</section>
				</div>
			</div>
		</div>	
<?php get_footer(); ?>