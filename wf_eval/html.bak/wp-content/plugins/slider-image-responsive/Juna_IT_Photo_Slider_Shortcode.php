<?php
	function Juna_IT_Photo_Slider_GET_Shortcode_ID($atts, $content = null)
	{
		$atts=shortcode_atts(
			array(
				"id"=>"1"
			),$atts
		);
		return Juna_IT_Photo_Slider_Draw_Shortcode($atts['id']);
	}
	add_shortcode('Juna_Photo_Slider', 'Juna_IT_Photo_Slider_GET_Shortcode_ID');
	function Juna_IT_Photo_Slider_Draw_Shortcode($Sid)
	{
		ob_start();	
			$args = shortcode_atts(array('name' => 'Widget Area','id'=>'','description'=>'','class'=>'','before_widget'=>'','after_widget'=>'','before_title'=>'','AFTER_TITLE'=>'','widget_id'=>'','widget_name'=>'Juna_IT_Photo_Slider'), $atts, 'Juna_IT_Photo_Slider' );
			$Juna_IT_Photo_Slider=new Juna_Photo_Slider;
			$instance=array('JIT_PSlider_id'=>$Sid);
			$Juna_IT_Photo_Slider->widget($args,$instance);	
			$cont[]= ob_get_contents();
		ob_end_clean();	
		return $cont[0];		
	}
?>