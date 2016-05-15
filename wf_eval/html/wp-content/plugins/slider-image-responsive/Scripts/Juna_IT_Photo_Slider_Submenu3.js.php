<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<script type="text/javascript">
	function JIT_PSlider_Back_Effect()
	{
		location.reload();
	}
	function JIT_PSlider_Reset1()
	{
		jQuery('#JIT_PSlider_search_text1').val('');
		jQuery('#JIT_PSlider_not1').html('');
		jQuery('.JIT_PSlider_Effect_Table1').hide();
		jQuery('.JIT_PSlider_Effect_Table').show();
	}
	function JIT_PSlider_Search1()
	{
		var nIntervId=setInterval(function(){
			var JIT_PSlider_search_text1=jQuery('#JIT_PSlider_search_text1').val();
			if(JIT_PSlider_search_text1!='')
			{
				var ajaxurl = object.ajaxurl;
				var data = {
				action: 'Search_JITPSlider_Effect_Click', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
				foobar: JIT_PSlider_search_text1, // translates into $_POST['foobar'] in PHP
				};
				jQuery.post(ajaxurl, data, function(response) {
					if(response=='')
					{
						jQuery('#JIT_PSlider_not1').html('* Requested Effect does not exist!');
						jQuery('.JIT_PSlider_Effect_Table1').hide();
						jQuery('.JIT_PSlider_Effect_Table').show();
					}
					else
					{
						jQuery('#JIT_PSlider_not1').html('');
						jQuery('.JIT_PSlider_Effect_Table').hide();
						jQuery('.JIT_PSlider_Effect_Table1').show();
						jQuery('.JIT_PSlider_Effect_Table1').empty();

						var searched_params=response.split(')*^*(');
						for(i=0;i<parseInt(searched_params.length-1);i++)
						{
							searched_params_callback=searched_params[i].split(')&*&(');
							
							jQuery('.JIT_PSlider_Effect_Table1').append("<tr><td class='JIT_PSlider_id_item1'><B><I>"+parseInt(parseInt(i)+1)+"</I></B></td><td class='JIT_PSlider_title_item1'><B><I>"+searched_params_callback[1]+"</I></B></td><td class='JIT_PSlider_effect_item1'><B><I>"+searched_params_callback[2]+"</I></B></td><td class='JIT_PSlider_edit_item1' onclick='Edit_JITPSlider_Effect("+searched_params_callback[0]+")'><B><I>Edit</I></B></td><td><B><I>Delete</I></B></td></tr>");							
						}
						clearInterval(nIntervId);
					}
				});
			}
			else
			{
				jQuery('.JIT_PSlider_Effect_Table1').hide();
				jQuery('.JIT_PSlider_Effect_Table').show();
			}
		}, 600);
	}
	function Edit_JITPSlider_Effect(Edited_ID)
	{
		jQuery('.JIT_PSlider_Submenu1_Div').fadeOut();
		jQuery('.JIT_PSlider_Main_Table1').fadeOut();
		jQuery('.JIT_PSlider_Effect_Table').fadeOut();
		jQuery('.JIT_PSlider_Effect_Table1').fadeOut();

		if(Edited_ID==0)
		{
			jQuery('#JIT_PSlider_EN').val('Juna-IT Slider');
			jQuery('#JIT_PSlider_ET').val('Juna Slider');

			setTimeout(function(){
				jQuery('.JIT_PSlider_Submenu1_Div1').fadeIn();
				jQuery('.JIT_PSlider_Main_Fieldset1').fadeIn();
				jQuery('#PSlider_Effec1').fadeIn();
			},500)
		}
		else if(Edited_ID==1)
		{
			jQuery('#JIT_PSlider_EN').val('Full Width Version');
			jQuery('#JIT_PSlider_ET').val('Full Width Slider');

			setTimeout(function(){
				jQuery('.JIT_PSlider_Submenu1_Div1').fadeIn();
				jQuery('.JIT_PSlider_Main_Fieldset1').fadeIn();
				jQuery('#PSlider_Effec2').fadeIn();
			},500)
		}		
		else if(Edited_ID==2)
		{
			jQuery('#JIT_PSlider_EN').val('Different Size Version');
			jQuery('#JIT_PSlider_ET').val('Different Size Slider');

			setTimeout(function(){
				jQuery('.JIT_PSlider_Submenu1_Div1').fadeIn();
				jQuery('.JIT_PSlider_Main_Fieldset1').fadeIn();
				jQuery('#PSlider_Effec3').fadeIn();
			},500)
		}
		else if(Edited_ID==3)
		{
			jQuery('#JIT_PSlider_EN').val('Vertical Thumbnail');
			jQuery('#JIT_PSlider_ET').val('Vertical Thumbnail');

			setTimeout(function(){
				jQuery('.JIT_PSlider_Submenu1_Div1').fadeIn();
				jQuery('.JIT_PSlider_Main_Fieldset1').fadeIn();
				jQuery('#PSlider_Effec4').fadeIn();
			},500)
		}
		else if(Edited_ID==4)
		{
			jQuery('#JIT_PSlider_EN').val('Horizontal Thumbnail');
			jQuery('#JIT_PSlider_ET').val('Horizontal Thumbnail');

			setTimeout(function(){
				jQuery('.JIT_PSlider_Submenu1_Div1').fadeIn();
				jQuery('.JIT_PSlider_Main_Fieldset1').fadeIn();
				jQuery('#PSlider_Effec5').fadeIn();
			},500)
		}
		else if(Edited_ID==5)
		{
			jQuery('#JIT_PSlider_EN').val('Thumbnail Slider');
			jQuery('#JIT_PSlider_ET').val('Thumbnail Slider');

			setTimeout(function(){
				jQuery('.JIT_PSlider_Submenu1_Div1').fadeIn();
				jQuery('.JIT_PSlider_Main_Fieldset1').fadeIn();
				jQuery('#PSlider_Effec6').fadeIn();
			},500)
		}
	}
	function JIT_PSlider_ET_Changed()
	{
		jQuery('#PSlider_Effec1').fadeOut();
		jQuery('#PSlider_Effec2').fadeOut();
		jQuery('#PSlider_Effec3').fadeOut();
		jQuery('#PSlider_Effec4').fadeOut();
		jQuery('#PSlider_Effec5').fadeOut();
		jQuery('#PSlider_Effec6').fadeOut();
		setTimeout(function(){
			if(jQuery('#JIT_PSlider_ET').val()=='Juna Slider')
			{
				jQuery('#PSlider_Effec1').fadeIn();
			}
			else if(jQuery('#JIT_PSlider_ET').val()=='Full Width Slider')
			{
				jQuery('#PSlider_Effec2').fadeIn();
			}
			else if(jQuery('#JIT_PSlider_ET').val()=='Different Size Slider')
			{
				jQuery('#PSlider_Effec3').fadeIn();
			}
			else if(jQuery('#JIT_PSlider_ET').val()=='Vertical Thumbnail')
			{
				jQuery('#PSlider_Effec4').fadeIn();
			}
			else if(jQuery('#JIT_PSlider_ET').val()=='Horizontal Thumbnail')
			{
				jQuery('#PSlider_Effec5').fadeIn();
			}
			else if(jQuery('#JIT_PSlider_ET').val()=='Thumbnail Slider')
			{
				jQuery('#PSlider_Effec6').fadeIn();
			}
		},500)	
	}
</script>