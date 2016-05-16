<?php
/**
 * The template for displaying all pages.
 *
 * @package Kasa
 */
 get_header(); ?>
 <?php while (have_posts()) : the_post(); ?>
 		<div class="page_title">
			<div class="container">
				<div class="gutter">
					<p><?php _e( 'Blog', 'kasa' ); ?></p>
				</div>
			</div>
		</div>
		<div id="content">
			<div class="container">
				<div class="sidebar_right clearfix">
					<section class="pagesection">
						<div class="gutter">
							<article class="singlepost">
								<h2><?php if(get_the_title($post->ID)) { the_title(); } else { the_time( get_option( 'date_format' ) ); } ?></h2>
								<p class="meta">
									<span class="label_date"><?php _e( 'Date', 'kasa' ); ?> <?php the_time( get_option( 'date_format' ) ); ?></span> 
									<span class="label_auth"><?php _e( 'Author', 'kasa' ); ?> <?php _e( 'By', 'kasa' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a></span> 
									<span class="label_category"><?php _e( 'Category', 'kasa' ); ?> <?php the_category(', '); ?></span>
								</p>
								<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
								<?php the_post_thumbnail($post->ID, 'featured'); ?>
								<?php endif; ?>
								<?php the_content(); ?>
								<p class="meta_tags"><?php the_tags(); ?></p>
								<p><?php posts_nav_link(); ?></p>
								<?php comments_template(); ?>
                                <?php kasa_paginate_page(); ?> 
							</article>
						</div>
					</section>
					<?php  get_sidebar(); ?>
				</div>
			</div>
		</div>
<?php endwhile; ?>		
<?php get_footer(); ?>