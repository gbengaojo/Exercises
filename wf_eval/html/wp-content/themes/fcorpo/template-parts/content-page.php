<?php
/**
 * The default template for displaying page content
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-content">
		<?php echo '<h1 class="entry-title">'.get_the_title().'</h1>'; ?>
		<?php
			/**
			 * Display Thumbnails if thumbnail is set for the post
			 */
			if ( has_post_thumbnail() ) :

				the_post_thumbnail();

			endif;
			
			the_content( __( 'Read More...', 'fcorpo') );
		?>
	</div>
	<div class="page-after-content">
		
		<?php if ( ! post_password_required() ) : ?>

	<?php if ('open' == $post->comment_status) : ?>
			<span class="comments-icon">
				<?php comments_popup_link(__( 'No Comments', 'fcorpo' ), __( '1 Comment', 'fcorpo' ), __( '% Comments', 'fcorpo' ), '', __( 'Comments are closed.', 'fcorpo' )); ?>
			</span>
		<?php endif; ?>
		<?php edit_post_link( __( 'Edit', 'fcorpo' ), '<span class="edit-icon">', '</span>' ); ?>


<?php endif; ?>
	</div>
</article>
