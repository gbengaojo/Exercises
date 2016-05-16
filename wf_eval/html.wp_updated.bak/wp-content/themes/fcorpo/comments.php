<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage fCorpo
 * @author tishonator
 * @since fCorpo 1.0.0
 *
 */
 
if ( post_password_required() ) {
	return;
}
?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comments">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'fcorpo' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h3><!-- #comments -->

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				) );
			?>
		</ol><!-- .comment-list -->

		<div class="comment-navigation">
		   
			<div class="alignleft"><?php previous_comments_link(); ?>
			</div><!-- .alignleft -->
	
			<div class="alignright"><?php next_comments_link(); ?>
			</div><!-- .alignright -->
			
		</div><!-- .comment-navigation -->

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'fcorpo' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
