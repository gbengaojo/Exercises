<?php 
/**
 * Template Name: Full Width
 * 
 * @package Kasa 
 */
 get_header(); ?>
 <?php while (have_posts()) : the_post(); ?>
 		<div class="page_title">
			<div class="container">
				<div class="gutter">
					<p><?php the_title(); ?></p>
				</div>
			</div>
		</div>
		<div id="content">
			<div class="container">
				<div class="sidebar_right clearfix">
					<section class="pagesection fullwidthpage">
						<div class="gutter">
							<article class="singlepost">
							    <h2><?php the_title(); ?></h2>
								<?php the_content(); ?>
								<p><?php posts_nav_link(); ?></p>
								<?php comments_template(); ?>
                                <?php kasa_paginate_page(); ?> 
							</article>
						</div>
					</section>
				</div>
			</div>
		</div>
<?php endwhile; ?>		
<?php get_footer(); ?>