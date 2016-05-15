<?php



/* MAIN TESTIMONIAL META BOX (SELECT BOX OF ROTATORS) */
function testimonial_rotator_metabox_select() 
{
	global $post;	
	$rotator_ids	= testimonial_rotator_break_piped_string( get_post_meta( $post->ID, '_rotator_id', true ) ); 
	
	$rating				= get_post_meta( $post->ID, '_rating', true );
	$cite				= get_post_meta( $post->ID, '_cite', true );
	
	$rotators = get_posts( array( 'post_type' => 'testimonial_rotator', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
?>

	<?php if(!count($rotators)) { ?>
		<p style="color: red;">
			<b><?php _e('No Testimonial Rotators have been created.', 'testimonial-rotator'); ?></b><br />
			<?php _e("You need to publish this testimonial so you don't lose your work and then go create a Testimonial Rotator. You can then edit this testimonial and select the rotator here.", 'testimonial-rotator'); ?>
		</p>
	<?php } else { ?>
		<p>
		<?php _e('Attach to Rotator: ', 'testimonial-rotator'); ?> &nbsp;

		<?php foreach($rotators as $rotator) { ?>
			<input type="checkbox" name="rotator_id[]" <?php echo in_array($rotator->ID, $rotator_ids) ? " CHECKED" : ""; ?> value="<?php echo $rotator->ID ?>"/> <?php echo $rotator->post_title ?> &nbsp; &nbsp;
		<?php } ?> 
		</p>
	<?php } ?>
	
	<div style="padding: 10px 0; margin: 10px 0; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc;">
		<label for="stars"><?php _e('Star Rating:', 'testimonial-rotator'); ?></label> &nbsp; 
		<input type="radio" name="rating" value="1"<?php if($rating == 1) echo " CHECKED"; ?> /> 1 &nbsp;
		<input type="radio" name="rating" value="2"<?php if($rating == 2) echo " CHECKED"; ?> /> 2 &nbsp;
		<input type="radio" name="rating" value="3"<?php if($rating == 3) echo " CHECKED"; ?> /> 3 &nbsp;
		<input type="radio" name="rating" value="4"<?php if($rating == 4) echo " CHECKED"; ?> /> 4 &nbsp;
		<input type="radio" name="rating" value="5"<?php if($rating == 5) echo " CHECKED"; ?> /> 5 &nbsp;
		<input type="radio" name="rating" value=""<?php if(!$rating) echo " CHECKED"; ?> /> <?php echo __("Don't Show", 'testimonial-rotator'); ?>
	</div>
	
	<p>
		<label for="cite"><?php _e('Author Information:', 'testimonial-rotator'); ?></label><br>
		<small><?php _e("Company Name, Credentials, etc. (this info shows below the author's testimonial by default)", 'testimonial-rotator'); ?></small>
	</p>
	
	<?php 
	
	wp_editor( $cite, 'testimonial-rotator-cite', array( 
										'tinymce' 			=> array( 'theme_advanced_buttons1' => 'bold,italic,link,unlink'), 
										'textarea_name' 	=> 'cite',
										'media_buttons' 	=> false, 
										'textarea_rows' 	=> 3, 
										'quicktags' 		=> false,
										"teeny" 			=> true
										
									) ); 
}


function testimonial_rotator_mce_buttons( $buttons, $editor_id ) 
{
	if ( "testimonial-rotator-cite" == $editor_id ) 
	{
		return array( 'bold', 'italic', 'link', 'unlink' );
	}
	return $buttons;
}
add_filter( 'teeny_mce_buttons', 'testimonial_rotator_mce_buttons', 10, 2 );


/* SAVE TESTIMONIAL META DATA */
function testimonial_rotator_save_testimonial_meta( $post_id, $post ) 
{
	global $post;  
	if( isset( $_POST ) && isset( $post->ID ) && get_post_type( $post->ID ) == "testimonial" )  
    {  
		// SAVE
		if ( isset( $_POST['rotator_id'] ) ) 
		{
			if( is_array($_POST['rotator_id']))
			{
				update_post_meta( $post_id, '_rotator_id', testimonial_rotator_make_piped_string($_POST['rotator_id']) );
			}
			else
			{
				update_post_meta( $post_id, '_rotator_id', strip_tags( $_POST['rotator_id'] ) ); 
			}
		}
		else
		{
			update_post_meta( $post_id, '_rotator_id', '' ); 
		}
		
		if ( isset( $_POST['rating'] ) ) 		{ update_post_meta( $post_id, '_rating', strip_tags( $_POST['rating'] ) ); }
		if ( isset( $_POST['cite'] ) ) 			{ update_post_meta( $post_id, '_cite', $_POST['cite'] ); }
		
	}
}