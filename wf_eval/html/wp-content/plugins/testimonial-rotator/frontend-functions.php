<?php



// SINGLE TESTIMONIAL
function testimonial_rotator_single( $content )
{
	global $post;
	
	// SINGLE TESTIMONIAL
	if( is_single() AND get_post_type() == "testimonial" )
	{
		$testimonial_id 	= isset($testimonial_id) ? $testimonial_id : $post->ID;
		
		
		// IF NO ROTATOR ID IS FOUND, GRAB THE FIRST ROTATOR ASSOCIATED
		if( !isset($rotator_id) )
		{
			$rotator_id 		= get_post_meta( $testimonial_id, '_rotator_id', true );
			$rotator_ids		= (array) testimonial_rotator_break_piped_string($rotator_id); 
			$rotator_id			= reset($rotator_ids);
		}
		
		$itemreviewed 		= get_post_meta( $rotator_id, '_itemreviewed', true );
		$img_size 			= get_post_meta( $rotator_id, '_img_size', true );
		$cite 				= get_post_meta( $testimonial_id, '_cite', true );
		$has_image 			= has_post_thumbnail() ? "has-image" : false;
		$template_name 		= get_post_meta( $rotator_id, '_template', true );
		
		
		$rating 			= (int) get_post_meta( $testimonial_id, '_rating', true );
		$title_heading 		= get_post_meta( $rotator_id, '_title_heading', true );
		

		// SANITIZE
		if( !trim($template_name) ) 				$template_name = "default";
		if( !trim($title_heading) ) 				$title_heading =  apply_filters('testimonial_rotator_title_heading', 'h2', $template_name, $rotator_id);

		$is_single_page = true;
		if(!$template_name) $template_name = apply_filters('testimonial_rotator_single_page_theme', 'default', $post->ID);
		
		
		// SET THE STARS FONT ICON
		$testimonial_rotator_star 	= apply_filters( 'testimonial_rotator_star', 'fa-star', $template_name, $rotator_id );
	
	
		// LOOK FOR content-testimonial IN TEMPLATE IN THEME
		$template = locate_template( array( "content-testimonial.php" ) );
			
		if( !$template AND $template_name != "default" AND $template_name != "longform" AND file_exists( dirname(__FILE__) . "/../testimonial-rotator-" . $template_name . "/templates/single-testimonial.php" ) )
		{
			$template = dirname(__FILE__) . "/../testimonial-rotator-" . $template_name . "/templates/single-testimonial.php";
		}
		else if( file_exists(dirname(__FILE__) . "/templates/{$template_name}/single-testimonial.php") )
		{
			$template = dirname(__FILE__) . "/templates/{$template_name}/single-testimonial.php";
		}
		
		if( $template )
		{
			// NO CUSTOM TEMPLATE, MODIFY THE CONTENT
			ob_start();
			
			$show_title = apply_filters('testimonial_rotator_single_show_title', false, $template_name, $testimonial_id, $rotator_id);
			$show_image = apply_filters('testimonial_rotator_single_show_image', false, $template_name, $testimonial_id, $rotator_id);
			$show_body = true;
			$show_stars = true;
			$show_author = true;
			$show_microdata = true;

			if( $template ) include( $template );
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
		else
		{
			return testimonial_rotator_error( sprintf(__("The template: %s could be found", "testimonial-rotator"), $template_name ) );
		}
	}
	
	return $content;
}

if( !is_admin() )
{
	add_filter( 'the_content', 'testimonial_rotator_single' );
}



// READ MORE, WHEN EXCERPT IT USED
function testimonial_rotator_excerpt_more( $more ) 
{
	global $post;
	if( $post->post_type == "testimonial" )
	{
		return ' <a href="' . get_permalink( $post->id ) . '" class="testimonial-rotator-view-more">' . apply_filters('testimonia_rotator_view_more', __('View Full', 'testimonial-rotator')) . ' &rarr;</a>';
	}
}
add_filter( 'excerpt_more', 'testimonial_rotator_excerpt_more' );



// ERROR HANDLING
function testimonial_rotator_error( $msg )
{
	$error_handling = get_option( 'testimonial-rotator-error-handling' );
	if(!$error_handling) $error_handling = "source";
	if(!$msg) $msg = __('Something unknown went wrong', 'testimonial-rotator');
	
	if( $error_handling == "display-admin")
	{
		// DISPLAY ADMIN
		if ( current_user_can( 'manage_options' ) ) 
		{
			echo "<div class='testimonial-rotator-error'>" . $msg . "</div>";
		}
	}
	else if( $error_handling == "display-all")
	{
		// DISPLAY ALL
		echo "<div class='testimonial-rotator-error'>" . $msg . "</div>";
	}
	else
	{
		echo apply_filters( 'testimonial_rotator_error', "<!-- TESTIMONIAL ROTATOR ERROR: " . $msg . " -->" );
	}
}