function JIT_PSlider_Upload_Photo_Clicked()
{
	var nIntervId = setInterval(function(){
		var code = jQuery('#JIT_PSlider_Upload_Photo_1').val();			
		if(code.indexOf('img')>0){
			var s=code.split('src="'); 
			var src=s[1].split('"');				
			jQuery('#JIT_PSlider_Upload_Photo_2').val(src[0]);
			if(jQuery('#JIT_PSlider_Upload_Photo_2').val().length>0){
				clearInterval(nIntervId);
			}				
		}
	},100)
}
function JIT_PSlider_Sort()
{
	jQuery('#JIT_PSlider_Photos_Ul').sortable({
      	update: function() {
        	jQuery("#JIT_PSlider_Photos_Ul > li").each(function(){
				jQuery(this).find('.JITPSLider_Uploaded_Title').attr('id','JITPSLider_Uploaded_Title_'+parseInt(parseInt(jQuery(this).index())+1));
				jQuery(this).find('.JITPSLider_Uploaded_Title').attr('name','JITPSLider_Uploaded_Title_'+parseInt(parseInt(jQuery(this).index())+1));

				jQuery(this).find('.JITPSLider_Uploaded_Photo').attr('id','JITPSLider_Uploaded_Photo_'+parseInt(parseInt(jQuery(this).index())+1));
				jQuery(this).find('.JITPSLider_Uploaded_Photo').attr('name','JITPSLider_Uploaded_Photo_'+parseInt(parseInt(jQuery(this).index())+1));

				jQuery(this).find('.JITPSLider_Uploaded_Link').attr('id','JITPSLider_Uploaded_Link_'+parseInt(parseInt(jQuery(this).index())+1));
				jQuery(this).find('.JITPSLider_Uploaded_Link').attr('name','JITPSLider_Uploaded_Link_'+parseInt(parseInt(jQuery(this).index())+1));

				jQuery(this).find('.JITPSLider_Uploaded_ONT').attr('id','JITPSLider_Uploaded_ONT_'+parseInt(parseInt(jQuery(this).index())+1));
				jQuery(this).find('.JITPSLider_Uploaded_ONT').attr('name','JITPSLider_Uploaded_ONT_'+parseInt(parseInt(jQuery(this).index())+1));
			});         
       	}
    });	
}
function JIT_PSlider_Remove_U(Remove_Title)
{
	jQuery('#JIT_PSlider_Photos_Ul_Li_'+Remove_Title).remove();

	jQuery('#JIT_PSlider_Hidden_Count').val(jQuery('#JIT_PSlider_Hidden_Count').val()-1);

	jQuery("#JIT_PSlider_Photos_Ul > li").each(function(){
		jQuery(this).find('.JITPSLider_Uploaded_Title').attr('id','JITPSLider_Uploaded_Title_'+parseInt(parseInt(jQuery(this).index())+1));
		jQuery(this).find('.JITPSLider_Uploaded_Title').attr('name','JITPSLider_Uploaded_Title_'+parseInt(parseInt(jQuery(this).index())+1));

		jQuery(this).find('.JITPSLider_Uploaded_Photo').attr('id','JITPSLider_Uploaded_Photo_'+parseInt(parseInt(jQuery(this).index())+1));
		jQuery(this).find('.JITPSLider_Uploaded_Photo').attr('name','JITPSLider_Uploaded_Photo_'+parseInt(parseInt(jQuery(this).index())+1));

		jQuery(this).find('.JITPSLider_Uploaded_Link').attr('id','JITPSLider_Uploaded_Link_'+parseInt(parseInt(jQuery(this).index())+1));
		jQuery(this).find('.JITPSLider_Uploaded_Link').attr('name','JITPSLider_Uploaded_Link_'+parseInt(parseInt(jQuery(this).index())+1));

		jQuery(this).find('.JITPSLider_Uploaded_ONT').attr('id','JITPSLider_Uploaded_ONT_'+parseInt(parseInt(jQuery(this).index())+1));
		jQuery(this).find('.JITPSLider_Uploaded_ONT').attr('name','JITPSLider_Uploaded_ONT_'+parseInt(parseInt(jQuery(this).index())+1));
	});	
	
	if(jQuery("#JIT_PSlider_Photos_Ul > li").length==0)
	{
		jQuery('#JIT_PSlider_Photos').fadeOut();
	}
	else
	{
		jQuery('#JIT_PSlider_Photos').fadeIn();
	}
}
function JIT_PSlider_Edit_U(Edit_Title)
{
	var Edited_Photo_Title=jQuery('#JIT_PSlider_Photos_Ul_Li_'+Edit_Title).find('.JITPSLider_Uploaded_Title').val();
	var Edited_Photo_URL=jQuery('#JIT_PSlider_Photos_Ul_Li_'+Edit_Title).find('.JITPSLider_Uploaded_Photo').val();
	var Edited_Photo_Link=jQuery('#JIT_PSlider_Photos_Ul_Li_'+Edit_Title).find('.JITPSLider_Uploaded_Link').val();
	var Edited_Photo_ONT=jQuery('#JIT_PSlider_Photos_Ul_Li_'+Edit_Title).find('.JITPSLider_Uploaded_ONT').val();
	jQuery('#JIT_PSlider_Lindex').val(Edit_Title);

	jQuery('#JIT_PSlider_Upload_Title').val(Edited_Photo_Title);
	jQuery('#JIT_PSlider_Upload_Photo_2').val(Edited_Photo_URL);
	jQuery('#JIT_PSlider_Upload_Link').val(Edited_Photo_Link);
	jQuery('#JIT_PSlider_YON').val(Edited_Photo_ONT);
	if(Edited_Photo_ONT=='Yes')
	{
		jQuery('.JITPSlidericon_Yes').css('color','#0073aa');
		jQuery('.JITPSlidericon_No').css('color','#c5c5c5');
	}
	else
	{
		jQuery('.JITPSlidericon_No').css('color','#0073aa');
		jQuery('.JITPSlidericon_Yes').css('color','#c5c5c5');
	}
	jQuery('#JIT_PSlider_Button_S').fadeOut();
	jQuery('.JIT_PSlider_Span').fadeOut();

	setTimeout(function(){
		jQuery('#JIT_PSlider_Button_U').fadeIn();
	},700)	
}