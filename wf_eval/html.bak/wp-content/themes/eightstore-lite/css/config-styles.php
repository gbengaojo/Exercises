<?php
add_action('wp_head' , 'eightstore_lite_dynamic_style');
function eightstore_lite_dynamic_style(){

//font-family for header h1 to h6.
	$eightstore_lite_heading_fonts = get_theme_mod('heading_typography');

//font-family for body text.
	$eightstore_lite_body_fonts = get_theme_mod('body_typography');

//typography format body
	$eightstore_lite_body_fonts_size = get_theme_mod('typography_size_body');
	$eightstore_lite_body_color = get_theme_mod('typography_color_body');

//typography format for h1 to h6

	$eightstore_lite_font_size_h1 = get_theme_mod('typography_format_h1');
	$eightstore_lite_text_transform_h1 = get_theme_mod('typography_type_h1');
	$eightstore_lite_color_h1 = get_theme_mod('typography_color_h1');

	$eightstore_lite_font_size_h2 = get_theme_mod('typography_format_h2');
	$eightstore_lite_text_transform_h2 = get_theme_mod('typography_type_h2');
	$eightstore_lite_color_h2 = get_theme_mod('typography_color_h2');

	$eightstore_lite_font_size_h3 = get_theme_mod('typography_format_h3');
	$eightstore_lite_text_transform_h3 = get_theme_mod('typography_type_h3');
	$eightstore_lite_color_h3 = get_theme_mod('typography_color_h3');

	$eightstore_lite_font_size_h4 = get_theme_mod('typography_format_h4');
	$eightstore_lite_text_transform_h4 = get_theme_mod('typography_type_h4');
	$eightstore_lite_color_h4 = get_theme_mod('typography_color_h4');

	$eightstore_lite_font_size_h5 = get_theme_mod('typography_format_h5');
	$eightstore_lite_text_transform_h5 = get_theme_mod('typography_type_h5');
	$eightstore_lite_color_h5 = get_theme_mod('typography_color_h5');

	$eightstore_lite_font_size_h6 = get_theme_mod('typography_format_h6');
	$eightstore_lite_text_transform_h6 = get_theme_mod('typography_type_h6');
	$eightstore_lite_color_h6 = get_theme_mod('typography_color_h6');

	?>
	<style type="text/css" id="dynamic-styles">
		body{
			<?php
			if(!empty($eightstore_lite_body_fonts)){ echo "font-family:".$eightstore_lite_body_fonts.";"; }
			if(!empty($eightstore_lite_body_fonts_size)){ echo "font-size:".$eightstore_lite_body_fonts_size."px;"; }
			if(!empty($eightstore_lite_body_color)){ echo "color:".$eightstore_lite_body_color.";"; }
			?>
		}

		
		<?php if(!empty($eightstore_lite_heading_fonts)){ echo "h1, h2, h3, h4, h5, h6 { font-family:".$eightstore_lite_heading_fonts."; }"; } ?>
		

		h1{
			<?php
			if(!empty($eightstore_lite_color_h1)){ echo "color:".$eightstore_lite_color_h1.";"; }
			if(!empty($eightstore_lite_font_size_h1)){ echo "font-size:".$eightstore_lite_font_size_h1."px;"; }
			?>
		}
		h2{
			<?php
			if(!empty($eightstore_lite_color_h2)){ echo "color:".$eightstore_lite_color_h2.";"; }
			if(!empty($eightstore_lite_font_size_h2)){ echo "font-size:".$eightstore_lite_font_size_h2."px;"; }
			?>
		}
		h3{
			<?php
			if(!empty($eightstore_lite_color_h3)){ echo "color:".$eightstore_lite_color_h3.";"; }
			if(!empty($eightstore_lite_font_size_h3)){ echo "font-size:".$eightstore_lite_font_size_h3."px;"; }
			?>
		}
		h4{
			<?php
			if(!empty($eightstore_lite_color_h4)){ echo "color:".$eightstore_lite_color_h4.";"; }
			if(!empty($eightstore_lite_font_size_h4)){ echo "font-size:".$eightstore_lite_font_size_h4."px;"; }
			?>
		}
		h5{
			<?php
			if(!empty($eightstore_lite_color_h5)){ echo "color:".$eightstore_lite_color_h5.";"; }
			if(!empty($eightstore_lite_font_size_h5)){ echo "font-size:".$eightstore_lite_font_size_h5."px;"; }
			?>
		}
		h6{
			<?php
			if(!empty($eightstore_lite_color_h6)){ echo "color:".$eightstore_lite_color_h6.";"; }
			if(!empty($eightstore_lite_font_size_h6)){ echo "font-size:".$eightstore_lite_font_size_h6."px;"; }
			?>
		}
	</style>
	<?php
}