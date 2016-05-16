<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<script type="text/javascript">
	function JIT_PSlider_Add()
	{
		jQuery('.JIT_PSlider_Submenu_Div').fadeOut();
		jQuery('.JIT_PSlider_Main_Table').fadeOut();
		jQuery('.JIT_PSlider_Table').fadeOut();
		jQuery('.JIT_PSlider_Table1').fadeOut();
		jQuery('#JIT_PSlider_Save_Submit').fadeIn();
		jQuery('#JIT_PSlider_Update_Submit').fadeOut();
		jQuery('.JIT_PSlider_Short_Div').fadeOut();

		setTimeout(function(){
			jQuery('.JIT_PSlider_Submenu_Div1').fadeIn();
			jQuery('.JIT_PSlider_Type_Div').fadeIn();
			jQuery('.JIT_PSlider_Add_Photo_Div').fadeIn();
		},500)	
	}
	function JIT_PSlider_Back()
	{
		location.reload();
	}	
	function JIT_PSlider_Main_Big_Clicked()
	{
		jQuery('#JIT_PSlider_Button_U').fadeOut();
		jQuery('#JIT_PSlider_Upload_Title').val('');
		jQuery('#JIT_PSlider_Upload_Photo_2').val('');
		jQuery('#JIT_PSlider_Upload_Link').val('');
		jQuery('#JIT_PSlider_YON').val('No');
		jQuery('.JITPSlidericon_No').css('color','#0073aa');
		jQuery('.JITPSlidericon_Yes').css('color','#c5c5c5');
		jQuery('.JIT_PSlider_Span').fadeOut();

		setTimeout(function(){
			jQuery('#JIT_PSlider_Button_S').fadeIn();
		},700)
	}
	function JIT_PSlider_ONT(YON)
	{
		jQuery('#JIT_PSlider_YON').val(YON);

		if(YON=='Yes')
		{
			jQuery('.JITPSlidericon_Yes').css('color','#0073aa');
			jQuery('.JITPSlidericon_No').css('color','#c5c5c5');
		}
		else
		{
			jQuery('.JITPSlidericon_No').css('color','#0073aa');
			jQuery('.JITPSlidericon_Yes').css('color','#c5c5c5');
		}
	}
	function JIT_PSlider_Save_Clicked()
	{
		var JITPSliderUT=jQuery('#JIT_PSlider_Upload_Title').val();
		var JITPSliderUP=jQuery('#JIT_PSlider_Upload_Photo_2').val();
		var JITPSliderUL=jQuery('#JIT_PSlider_Upload_Link').val();
		var JITPSliderYN=jQuery('#JIT_PSlider_YON').val();
		if(JITPSliderYN=='Yes')
		{
			JITPSliderColorY='#0073aa';
			JITPSliderColorN='#c5c5c5';
		}
		else
		{
			JITPSliderColorY='#c5c5c5';
			JITPSliderColorN='#0073aa';
		}
		var JITPSLiderHC=jQuery('#JIT_PSlider_Hidden_Count').val();
		jQuery('#JIT_PSlider_Upload_Photo_1').val('');

		var JITPSLiderNHC=parseInt(parseInt(JITPSLiderHC)+1);

		if(JITPSliderUT=='' || JITPSliderUP=='')
		{
			if(JITPSliderUT=='' && JITPSliderUP=='')
			{
				jQuery('#JIT_PSlider_Span_1').fadeIn();
				jQuery('#JIT_PSlider_Span_2').fadeIn();
				return false;
			}
			if (JITPSliderUT=='') 
			{
				jQuery('#JIT_PSlider_Span_1').fadeIn();
				jQuery('#JIT_PSlider_Span_2').fadeOut();
				return false;
			}
			if(JITPSliderUP=='')
			{
				jQuery('#JIT_PSlider_Span_2').fadeIn();
				jQuery('#JIT_PSlider_Span_1').fadeOut();
				return false;
			}			
		}
		else
		{
			jQuery('#JIT_PSlider_Photos_Ul').append('<li id="JIT_PSlider_Photos_Ul_Li_'+JITPSLiderNHC+'"><div class="JIT_PSlider_Photos_Desc_Div"><table class="JIT_PSlider_Photos_Table"><tr><td colspan="2"><i class="junaiticonsdraw junaiticons-style junaiticons-remove" style="cursor:pointer;float:right;font-size: 20px; color:#ff0000" onclick="JIT_PSlider_Remove_U('+JITPSLiderNHC+')"></i><i class="junaiticonsdraw junaiticons-style junaiticons-edit" style="cursor:pointer;float:right;margin-right:10px;font-size: 22px; color:#0073aa" onclick="JIT_PSlider_Edit_U('+JITPSLiderNHC+')"></i></td></tr><tr><td><label>Title</label></td><td><input type="text" class="JIT_PSlider_Upload_Photo_Input JITPSLider_Uploaded_Title" id="JITPSLider_Uploaded_Title_'+JITPSLiderNHC+'" name="JITPSLider_Uploaded_Title_'+JITPSLiderNHC+'" value="'+JITPSliderUT+'" readonly></td></tr><tr><td><label>URL</label></td><td><input type="text" class="JIT_PSlider_Upload_Photo_Input JITPSLider_Uploaded_Photo" id="JITPSLider_Uploaded_Photo_'+JITPSLiderNHC+'" name="JITPSLider_Uploaded_Photo_'+JITPSLiderNHC+'" value="'+JITPSliderUP+'" readonly></td></tr><tr><td><label>Link</label></td><td><input type="text" class="JIT_PSlider_Upload_Photo_Input JITPSLider_Uploaded_Link" id="JITPSLider_Uploaded_Link_'+JITPSLiderNHC+'" name="JITPSLider_Uploaded_Link_'+JITPSLiderNHC+'" value="'+JITPSliderUL+'" readonly></td></tr><tr><td><label>New Tab</label></td><td style="text-align: center"><input type="hidden" class="JITPSLider_Uploaded_ONT" id="JITPSLider_Uploaded_ONT_'+JITPSLiderNHC+'" name="JITPSLider_Uploaded_ONT_'+JITPSLiderNHC+'" value="'+JITPSliderYN+'"><i class="JITPSC junaiticonsdraw junaiticons-style junaiticons-check"  style="margin-right:20px;font-size: 20px; color:'+JITPSliderColorY+'"></i><i class="JITPSR junaiticonsdraw junaiticons-style junaiticons-remove"  style="font-size: 20px; color:'+JITPSliderColorN+'"></i></td></tr></table></div><div class="JIT_PSlider_Photos_Div" id="JIT_PSlider_Photos_Div_'+JITPSLiderNHC+'"><img class="JIT_PSlider_Photo" id="JIT_PSlider_Photo_'+JITPSLiderNHC+'" src="'+JITPSliderUP+'"></div></li>');

			jQuery('#JIT_PSlider_Hidden_Count').val(JITPSLiderNHC);

			jQuery('#JIT_PSlider_Upload_Title').val('');
			jQuery('#JIT_PSlider_Upload_Photo_2').val('');
			jQuery('#JIT_PSlider_Upload_Link').val('');
			jQuery('#JIT_PSlider_YON').val('No');
			jQuery('.JITPSlidericon_No').css('color','#0073aa');
			jQuery('.JITPSlidericon_Yes').css('color','#c5c5c5');
			jQuery('#JIT_PSlider_Button_U').fadeOut();
			jQuery('.JIT_PSlider_Span').fadeOut();
			jQuery('#JIT_PSlider_Photos').fadeIn();
			setTimeout(function(){
				jQuery('#JIT_PSlider_Button_S').fadeIn();
			},700)
		}
	}
	function JIT_PSlider_Up_Clicked()
	{
		var JITPSlider_Lindex=jQuery('#JIT_PSlider_Lindex').val();

		if(jQuery('#JIT_PSlider_Upload_Title').val()=='' || jQuery('#JIT_PSlider_Upload_Photo_2').val()=='')
		{
			if(jQuery('#JIT_PSlider_Upload_Title').val()=='' && jQuery('#JIT_PSlider_Upload_Photo_2').val()=='')
			{
				jQuery('#JIT_PSlider_Span_1').fadeIn();
				jQuery('#JIT_PSlider_Span_2').fadeIn();
				return false;
			}
			if(jQuery('#JIT_PSlider_Upload_Title').val()=='')
			{
				jQuery('#JIT_PSlider_Span_1').fadeIn();
				jQuery('#JIT_PSlider_Span_2').fadeOut();
				return false;
			}
			if(jQuery('#JIT_PSlider_Upload_Photo_2').val()=='')
			{
				jQuery('#JIT_PSlider_Span_2').fadeIn();
				jQuery('#JIT_PSlider_Span_1').fadeOut();
				return false;
			}
		}
		else
		{
			jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSLider_Uploaded_Title').val(jQuery('#JIT_PSlider_Upload_Title').val());
			jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSLider_Uploaded_Photo').val(jQuery('#JIT_PSlider_Upload_Photo_2').val());
			jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSLider_Uploaded_Link').val(jQuery('#JIT_PSlider_Upload_Link').val());
			jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSLider_Uploaded_ONT').val(jQuery('#JIT_PSlider_YON').val());
			jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JIT_PSlider_Photo').attr('src',jQuery('#JIT_PSlider_Upload_Photo_2').val());

			if(jQuery('#JIT_PSlider_YON').val()=='Yes')
			{
				jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSC').css('color','#0073aa');
				jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSR').css('color','#c5c5c5');
			}
			else
			{
				jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSR').css('color','#0073aa');
				jQuery('#JIT_PSlider_Photos_Ul_Li_'+JITPSlider_Lindex).find('.JITPSC').css('color','#c5c5c5');
			}

			jQuery('#JIT_PSlider_Upload_Title').val('');
			jQuery('#JIT_PSlider_Upload_Photo_2').val('');
			jQuery('#JIT_PSlider_Upload_Link').val('');
			jQuery('#JIT_PSlider_YON').val('No');
			jQuery('.JITPSlidericon_No').css('color','#0073aa');
			jQuery('.JITPSlidericon_Yes').css('color','#c5c5c5');
			jQuery('#JIT_PSlider_Button_U').fadeOut();
			jQuery('.JIT_PSlider_Span').fadeOut();
			setTimeout(function(){
				jQuery('#JIT_PSlider_Button_S').fadeIn();
			},700)
		}		
	}
	function Edit_JITPSlider(Edited_ID)
	{
		jQuery('.JIT_PSlider_Submenu_Div').fadeOut();
		jQuery('.JIT_PSlider_Main_Table').fadeOut();
		jQuery('.JIT_PSlider_Table').fadeOut();
		jQuery('.JIT_PSlider_Table1').fadeOut();
		jQuery('#JIT_PSlider_Update_Submit').fadeIn();
		jQuery('#JIT_PSlider_Save_Submit').fadeOut();
		jQuery('.JIT_PSlider_Short_Div').fadeOut();

		var ajaxurl = object.ajaxurl;
		var data = {
		action: 'Edit_JIT_PSlider', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
		foobar: Edited_ID, // translates into $_POST['foobar'] in PHP
		};
		jQuery.post(ajaxurl, data, function(response) {
			var JITPSLider_Params=response.split('^%^');
			jQuery('#JIT_PSlider_Name').val(JITPSLider_Params[0]);
			jQuery('#JIT_PSlider_Hidden_SN').val(JITPSLider_Params[0]);
			jQuery('#JIT_PSlider_Type').val(JITPSLider_Params[1]);
			jQuery('#JIT_PSlider_Hidden_Count').val(JITPSLider_Params[2]);
			jQuery('#JIT_PSlider_Hidden_ID').val(Edited_ID);

			var JITPSLider_PParams=JITPSLider_Params[3].split(')*(');

			for(var y=0;y<JITPSLider_Params[2];y++)
			{
				var JITPSLider_Input_params=JITPSLider_PParams[y].split('$#$');

				if(JITPSLider_Input_params[3]=='Yes')
				{
					JITPSliderColorY='#0073aa';
					JITPSliderColorN='#c5c5c5';
				}
				else
				{
					JITPSliderColorY='#c5c5c5';
					JITPSliderColorN='#0073aa';
				}

				jQuery('#JIT_PSlider_Photos_Ul').append('<li id="JIT_PSlider_Photos_Ul_Li_'+parseInt(parseInt(y)+1)+'"><div class="JIT_PSlider_Photos_Desc_Div"><table class="JIT_PSlider_Photos_Table"><tr><td colspan="2"><i class="junaiticonsdraw junaiticons-style junaiticons-remove" style="cursor:pointer;float:right;font-size: 20px; color:#ff0000" onclick="JIT_PSlider_Remove_U('+parseInt(parseInt(y)+1)+')"></i><i class="junaiticonsdraw junaiticons-style junaiticons-edit" style="cursor:pointer;float:right;margin-right:10px;font-size: 22px; color:#0073aa" onclick="JIT_PSlider_Edit_U('+parseInt(parseInt(y)+1)+')"></i></td></tr><tr><td><label>Title</label></td><td><input type="text" class="JIT_PSlider_Upload_Photo_Input JITPSLider_Uploaded_Title" id="JITPSLider_Uploaded_Title_'+parseInt(parseInt(y)+1)+'" name="JITPSLider_Uploaded_Title_'+parseInt(parseInt(y)+1)+'" value="'+JITPSLider_Input_params[0]+'" readonly></td></tr><tr><td><label>URL</label></td><td><input type="text" class="JIT_PSlider_Upload_Photo_Input JITPSLider_Uploaded_Photo" id="JITPSLider_Uploaded_Photo_'+parseInt(parseInt(y)+1)+'" name="JITPSLider_Uploaded_Photo_'+parseInt(parseInt(y)+1)+'" value="'+JITPSLider_Input_params[1]+'" readonly></td></tr><tr><td><label>Link</label></td><td><input type="text" class="JIT_PSlider_Upload_Photo_Input JITPSLider_Uploaded_Link" id="JITPSLider_Uploaded_Link_'+parseInt(parseInt(y)+1)+'" name="JITPSLider_Uploaded_Link_'+parseInt(parseInt(y)+1)+'" value="'+JITPSLider_Input_params[2]+'" readonly></td></tr><tr><td><label>New Tab</label></td><td style="text-align: center"><input type="hidden" class="JITPSLider_Uploaded_ONT" id="JITPSLider_Uploaded_ONT_'+parseInt(parseInt(y)+1)+'" name="JITPSLider_Uploaded_ONT_'+parseInt(parseInt(y)+1)+'" value="'+JITPSLider_Input_params[3]+'"><i class="JITPSC junaiticonsdraw junaiticons-style junaiticons-check"  style="margin-right:20px;font-size: 20px; color:'+JITPSliderColorY+'"></i><i class="JITPSR junaiticonsdraw junaiticons-style junaiticons-remove"  style="font-size: 20px; color:'+JITPSliderColorN+'"></i></td></tr></table></div><div class="JIT_PSlider_Photos_Div" id="JIT_PSlider_Photos_Div_'+parseInt(parseInt(y)+1)+'"><img class="JIT_PSlider_Photo" id="JIT_PSlider_Photo_'+parseInt(parseInt(y)+1)+'" src="'+JITPSLider_Input_params[1]+'"></div></li>');
			}
			
			setTimeout(function(){
				jQuery('.JIT_PSlider_Submenu_Div1').fadeIn();
				jQuery('.JIT_PSlider_Type_Div').fadeIn();
				jQuery('.JIT_PSlider_Add_Photo_Div').fadeIn();
				jQuery('#JIT_PSlider_Photos').fadeIn();
			},500)
		})
	}
	function Delete_JITPSlider(Deleted_ID)
	{
		var ajaxurl = object.ajaxurl;
		var data = {
		action: 'Delete_JITPSlider_Click', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
		foobar: Deleted_ID, // translates into $_POST['foobar'] in PHP
		};
		jQuery.post(ajaxurl, data, function(response) {
			location.reload();
		});
	}
	function JIT_PSlider_Search()
	{
		var nIntervId=setInterval(function(){
			var JIT_PSlider_search_text=jQuery('#JIT_PSlider_search_text').val();
			if(JIT_PSlider_search_text!='')
			{
				var ajaxurl = object.ajaxurl;
				var data = {
				action: 'Search_JITPSlider_Click', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
				foobar: JIT_PSlider_search_text, // translates into $_POST['foobar'] in PHP
				};
				jQuery.post(ajaxurl, data, function(response) {
					if(response=='')
					{
						jQuery('#JIT_PSlider_not').html('* Requested Slider does not exist!');
						jQuery('.JIT_PSlider_Table1').hide();
						jQuery('.JIT_PSlider_Table').show();
					}
					else
					{
						jQuery('#JIT_PSlider_not').html('');
						jQuery('.JIT_PSlider_Table').hide();
						jQuery('.JIT_PSlider_Table1').show();
						jQuery('.JIT_PSlider_Table1').empty();

						var searched_params=response.split(')*^*(');
						var Shortpart1='[Juna_Photo_Slider id="';
						var Shortpart2='"]';
						for(i=0;i<parseInt(searched_params.length-1);i++)
						{
							searched_params_callback=searched_params[i].split(')&*&(');
							
							jQuery('.JIT_PSlider_Table1').append("<tr><td class='JIT_PSlider_id_item'><B><I>"+parseInt(parseInt(i)+1)+"</I></B></td><td class='JIT_PSlider_title_item'><B><I>"+searched_params_callback[1]+"</I></B></td><td class='JIT_PSlider_quantity_video_item'><B><I>"+searched_params_callback[3]+"</I></B></td><td class='JIT_PSlider_type_video_item'><B><I>"+searched_params_callback[2]+"</I></B></td><td class='JIT_PSlider_views_item'>"+Shortpart1+searched_params_callback[0]+Shortpart2+"</td><td class='JIT_PSlider_edit_item' onclick='Edit_JITPSlider("+searched_params_callback[0]+")'><B><I>Edit</I></B></td><td class='JIT_PSlider_delete_item' onclick='Delete_JITPSlider("+searched_params_callback[0]+")'><B><I>Delete</I></B></td></tr>");
						}
						clearInterval(nIntervId);
					}
				});
			}
			else
			{
				jQuery('.JIT_PSlider_Table1').hide();
				jQuery('.JIT_PSlider_Table').show();
			}
		}, 600);
	}	
	function JIT_PSlider_Reset()
	{
		jQuery('#JIT_PSlider_search_text').val('');
		jQuery('#JIT_PSlider_not').html('');
		jQuery('.JIT_PSlider_Table1').hide();
		jQuery('.JIT_PSlider_Table').show();
	}
</script>