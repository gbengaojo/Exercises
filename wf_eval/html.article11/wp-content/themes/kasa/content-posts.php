<?php 
/**
 * 
 * @package Kasa 
 */
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<h2><a href="<?php the_permalink() ?>"><?php if(get_the_title($post->ID)) { the_title(); } else { the_time( get_option( 'date_format' ) ); } ?></a></h2>
	<p class="meta">
			<span class="label_date"><?php _e( 'Date', 'kasa' ); ?> <?php the_time( get_option( 'date_format' ) ); ?></span> 
			<span class="label_auth"><?php _e( 'Author', 'kasa' ); ?> <?php _e( 'By', 'kasa' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a></span> 
			<span class="label_category"><?php _e( 'Category', 'kasa' ); ?> <?php the_category(', '); ?></span>
	</p>
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
	<?php the_post_thumbnail($post->ID, 'featured'); ?> 
	<?php endif; ?>
	<?php the_excerpt(); ?>
	<a class="button" href="<?php the_permalink() ?>"><?php _e( 'Read More', 'kasa' ); ?></a>
</article>