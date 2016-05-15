jQuery(document).ready(function ($) {	
	var JIT_PSlider_ET=jQuery('#JIT_PSlider_ET').val();
	if(JIT_PSlider_ET=='Juna Slider')
	{
		var JIT_PSlider_SD=jQuery('#JIT_PSlider_SD').val();
		var JIT_PSlider_AutoPlay=jQuery('#JIT_PSlider_AutoPlay').val();
		var JIT_PSlider_CS=jQuery('#JIT_PSlider_CS').val();
		var JIT_PSlider_PT=jQuery('#JIT_PSlider_PT').val();
		var JIT_PSlider_SS=jQuery('#JIT_PSlider_SS').val();
		var JIT_PSlider_AS=jQuery('#JIT_PSlider_AS').val();
		var JIT_PSlider_CW=jQuery('#JIT_PSlider_CW').val();

		if(JIT_PSlider_AutoPlay=='true')
		{
			JIT_PSlider_AutoPlay_real=true;
		}
		else if(JIT_PSlider_AutoPlay=='false')
		{
			JIT_PSlider_AutoPlay_real=false;
		}

		var JIT_PSlider_Glob_SlideshowTransitions = [
		    {$Duration:parseInt(JIT_PSlider_SD),x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
		    {$Duration:parseInt(JIT_PSlider_SD),x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
		];
		var JIT_PSlider_Glob_options = {
		    $AutoPlay: JIT_PSlider_AutoPlay_real, 
		    $Idle: parseInt(JIT_PSlider_PT),
		    $SlideDuration: parseInt(JIT_PSlider_CS),
		    $SlideSpacing: parseInt(JIT_PSlider_SS),
		    $SlideshowOptions: {
		      $Class: $JssorSlideshowRunner$,
		      $Transitions: JIT_PSlider_Glob_SlideshowTransitions,
		      $TransitionsOrder: 1
		    },
		    $ArrowNavigatorOptions: {
		      $Class: $JssorArrowNavigator$,
		      $Steps: parseInt(JIT_PSlider_AS)
		    },
		    $BulletNavigatorOptions: {
		      $Class: $JssorBulletNavigator$
		    },
		    $ThumbnailNavigatorOptions: {
		      $Class: $JssorThumbnailNavigator$,
		      $Cols: 1,
		      $Align: 0
		    }
		};
		jQuery('.JIT_PSlider_Main_Div').each(function(){
			var JIT_PSlider_Main_Div_ID=jQuery(this).attr('id');
	    	var JIT_PSlider_Glob_slider=new $JssorSlider$(JIT_PSlider_Main_Div_ID, JIT_PSlider_Glob_options);
		
		    //responsive code begin
		    //you can remove responsive code if you don't want the slider scales while window resizing
		    function ScaleSlider() {
		        var refSize = JIT_PSlider_Glob_slider.$Elmt.parentNode.clientWidth;
		        if (refSize) {
		            refSize = Math.min(refSize, parseInt(JIT_PSlider_CW));
		            JIT_PSlider_Glob_slider.$ScaleWidth(refSize);
		        }
		        else {
		            window.setTimeout(ScaleSlider, 30);
		        }
		    }
		    ScaleSlider();
		    jQuery(window).bind("load", ScaleSlider);
		    jQuery(window).bind("resize", ScaleSlider);
		    jQuery(window).bind("orientationchange", ScaleSlider);
		    //responsive code end
	    })
	}
	var JIT_PSlider_ET1=jQuery('#JIT_PSlider_ET1').val();
	if(JIT_PSlider_ET1=='Full Width Slider')
	{
		var JIT_PSlider_AP=jQuery('#JIT_PSlider_AP').val();
		var JIT_PSlider_APS=jQuery('#JIT_PSlider_APS').val();
		var JIT_PSlider_FWS_CS=jQuery('#JIT_PSlider_FWS_CS').val();
		var JIT_PSlider_FWS_PT=jQuery('#JIT_PSlider_FWS_PT').val();
		var JIT_PSlider_FWS_SS=jQuery('#JIT_PSlider_FWS_SS').val();
		var JIT_PSlider_FWS_AS=jQuery('#JIT_PSlider_FWS_AS').val();
		var JIT_PSlider_SW=jQuery('#JIT_PSlider_SW').val();
		var JIT_PSlider_SC=jQuery('#JIT_PSlider_SC').val();

		if(JIT_PSlider_AP=='true')
		{
			JIT_PSlider_AP_real=true;
		}
		else if(JIT_PSlider_AP=='false')
		{
			JIT_PSlider_AP_real=false;
		}

		var JIT_PSlider_FWS_Glob_SlideoTransitions = [
	      [{b:4500,d:3000,o:-1,r:240,e:{r:2}}],
	      [{b:4500,d:3000,o:-1,r:-240,e:{r:2}}],
	      [{b:-1,d:1,o:-1,c:{x:51.0,t:-51.0}},{b:0,d:1000,o:1,c:{x:-51.0,t:51.0},e:{o:7,c:{x:7,t:7}}}],
	      [{b:2000,d:1100,x:0,y:0,o:-1,r:30,sX:9,sY:9,e:{x:2,y:6,r:1,sX:5,sY:5}}],
	      [{b:2000,d:1100,x:0,y:0,o:-1,r:-30,sX:9,sY:9,e:{x:2,y:6,r:1,sX:5,sY:5}}],
	      [{b:-1,d:1,o:-1,sX:9,sY:9},{b:1000,d:1000,o:1,r:720,sX:-9,sY:-9,e:{sX:2,sY:2,r:2}}],
	      [{b:-1,d:1,o:-1,r:-180,sX:9,sY:9},{b:2000,d:1000,o:1,r:180,sX:-9,sY:-9,e:{r:2,sX:2,sY:2}}],
	      [{b:-1,d:1,o:-1},{b:1000,d:1000,y:0,o:1,e:{y:16}}],
	      [{b:-1,d:1,o:-1,r:-240},{b:2500,d:1600,o:1,r:240,e:{r:3}}],
	      [{b:5000,d:2000,x:-1300,e:{x:7}}],
	      [{b:-1,d:1,o:-1,r:288,sX:9,sY:9},{b:2100,d:2000,x:0,y:0,o:1,r:-288,sX:-9,sY:-9,e:{r:6}},{b:5000,d:1600,x:-1300,o:-1,e:{x:16}}],
	      [{b:4000,d:2000,y:-1500,e:{y:27}}],
	      [{b:4000,d:4000,o:-1,r:1500,x:-1300,e:{r:2,x:27}}],
          [{b:4000,d:600,x:1300,e:{x:27}}],
          [{b:-1,d:1,o:-1},{b:0,d:1500,o:1,e:{o:5}}],
          [{b:-1,d:1,c:{x:175.0,t:-175.0}},{b:0,d:800,c:{x:-175.0,t:175.0},e:{c:{x:7,t:7}}}],
          [{b:-1,d:1,o:-1,r:-180},{b:0,d:800,o:1,r:180,e:{r:7}}],         
	    ];
	    
	    var JIT_PSlider_FWS_Glob_options = {
	      $AutoPlay: JIT_PSlider_AP_real,
	      $AutoPlaySteps: parseInt(JIT_PSlider_APS),
	      $Idle: parseInt(JIT_PSlider_FWS_PT),
	      $SlideDuration: parseInt(JIT_PSlider_FWS_CS),
	      $SlideWidth: parseInt(JIT_PSlider_SW),
	      $SlideSpacing: parseInt(JIT_PSlider_FWS_SS),
	      $Cols: parseInt(JIT_PSlider_SC),
	      $SlideEasing: $Jease$.$OutQuint,
	      $CaptionSliderOptions: {
	        $Class: $JssorCaptionSlideo$,
	        $Transitions: JIT_PSlider_FWS_Glob_SlideoTransitions
	      },
	      $ArrowNavigatorOptions: {
	        $Class: $JssorArrowNavigator$,
	        $Steps: parseInt(JIT_PSlider_FWS_AS)
	      },
	      $BulletNavigatorOptions: {
	        $Class: $JssorBulletNavigator$
	      },
	    };
	    
	    jQuery('.JIT_PSlider_FWS_Main_Div').each(function(){

	    	var JIT_PSlider_FWS_Main_Div_ID=jQuery(this).attr('id');
		    var JIT_PSlider_FWS_Glob_slider = new $JssorSlider$(JIT_PSlider_FWS_Main_Div_ID, JIT_PSlider_FWS_Glob_options);
		    
		    //responsive code begin
		    //you can remove responsive code if you don't want the slider scales while window resizing
		    function ScaleSlider() {
		        var refSize = JIT_PSlider_FWS_Glob_slider.$Elmt.parentNode.clientWidth;
		        if (refSize) {
		            refSize = Math.min(refSize, 1920);
		            JIT_PSlider_FWS_Glob_slider.$ScaleWidth(refSize);
		        }
		        else {
		            window.setTimeout(ScaleSlider, 30);
		        }
		    }
		    ScaleSlider();
		    $(window).bind("load", ScaleSlider);
		    $(window).bind("resize", ScaleSlider);
		    $(window).bind("orientationchange", ScaleSlider);
		    //responsive code end
		})
	}
	var JIT_PSlider_ET2=jQuery('#JIT_PSlider_ET2').val();
	if(JIT_PSlider_ET2=='Different Size Slider')
	{
		var JIT_PSlider_DSS_AP=jQuery('#JIT_PSlider_DSS_AP').val();
		var JIT_PSlider_DSS_CS=jQuery('#JIT_PSlider_DSS_CS').val();
		var JIT_PSlider_DSS_PT=jQuery('#JIT_PSlider_DSS_PT').val();
		var JIT_PSlider_DSS_SS=jQuery('#JIT_PSlider_DSS_SS').val();
		var JIT_PSlider_DSS_AS=jQuery('#JIT_PSlider_DSS_AS').val();
		var JIT_PSlider_DSS_CW=jQuery('#JIT_PSlider_DSS_CW').val().split('px')[0];

		if(JIT_PSlider_DSS_AP=='true')
		{
			JIT_PSlider_DSS_AP_real=true;
		}
		else if(JIT_PSlider_DSS_AP=='false')
		{
			JIT_PSlider_DSS_AP_real=false;
		}
		
        var JIT_PSlider_DSS_Main_Div_SlideshowTransitions = [
          {$Duration:1200,$Zoom:11,$Rotate:-1,$Easing:{$Zoom:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Round:{$Rotate:0.5},$Brother:{$Duration:1200,$Zoom:1,$Rotate:1,$Easing:$Jease$.$Swing,$Opacity:2,$Round:{$Rotate:0.5},$Shift:90}},
          {$Duration:1400,x:0.25,$Zoom:1.5,$Easing:{$Left:$Jease$.$InWave,$Zoom:$Jease$.$InSine},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1400,x:-0.25,$Zoom:1.5,$Easing:{$Left:$Jease$.$InWave,$Zoom:$Jease$.$InSine},$Opacity:2,$ZIndex:-10}},
          {$Duration:1200,$Zoom:11,$Rotate:1,$Easing:{$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Round:{$Rotate:1},$ZIndex:-10,$Brother:{$Duration:1200,$Zoom:11,$Rotate:-1,$Easing:{$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Round:{$Rotate:1},$ZIndex:-10,$Shift:600}},
          {$Duration:1500,x:0.5,$Cols:2,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InOutCubic},$Opacity:2,$Brother:{$Duration:1500,$Opacity:2}},
          {$Duration:1500,x:-0.3,y:0.5,$Zoom:1,$Rotate:0.1,$During:{$Left:[0.6,0.4],$Top:[0.6,0.4],$Rotate:[0.6,0.4],$Zoom:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1000,$Zoom:11,$Rotate:-0.5,$Easing:{$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Shift:200}},
          {$Duration:1500,$Zoom:11,$Rotate:0.5,$During:{$Left:[0.4,0.6],$Top:[0.4,0.6],$Rotate:[0.4,0.6],$Zoom:[0.4,0.6]},$Easing:{$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1000,$Zoom:1,$Rotate:-0.5,$Easing:{$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Shift:200}},
          {$Duration:1500,x:0.3,$During:{$Left:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Opacity:$Jease$.$Linear},$Opacity:2,$Outside:true,$Brother:{$Duration:1000,x:-0.3,$Easing:{$Left:$Jease$.$InQuad,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,x:0.25,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1200,x:-0.1,y:-0.7,$Rotate:0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
          {$Duration:1600,x:1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,x:-1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1600,x:1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,x:-1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1600,y:-1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,y:1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,y:1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1200,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,x:1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1200,x:-1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1200,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Shift:-100}},
          {$Duration:1200,x:1,$Delay:40,$Cols:6,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1200,x:1,$Delay:40,$Cols:6,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Shift:-100}},
          {$Duration:1500,x:-0.1,y:-0.7,$Rotate:0.1,$During:{$Left:[0.6,0.4],$Top:[0.6,0.4],$Rotate:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1000,x:0.2,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
          {$Duration:1600,x:-0.2,$Delay:40,$Cols:12,$During:{$Left:[0.4,0.6]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5},$Brother:{$Duration:1000,x:0.2,$Delay:40,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:1028,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Round:{$Top:0.5}}}
        ];
        
        var JIT_PSlider_DSS_Main_Div_options = {
          $AutoPlay: JIT_PSlider_DSS_AP_real,
          $FillMode: 5,
          $Idle: parseInt(JIT_PSlider_DSS_PT),
          $SlideDuration: parseInt(JIT_PSlider_DSS_CS),
          $SlideSpacing: parseInt(JIT_PSlider_DSS_SS),
          $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: JIT_PSlider_DSS_Main_Div_SlideshowTransitions,
            $TransitionsOrder: 1
          },
          $ArrowNavigatorOptions: {
	        $Class: $JssorArrowNavigator$,
	        $Steps: parseInt(JIT_PSlider_DSS_AS)
	      },
          $BulletNavigatorOptions: {
            $Class: $JssorBulletNavigator$
          },
        };

		jQuery('.JIT_PSlider_DSS_Main_Div').each(function(){
        	
        	var JIT_PSlider_DSS_Main_Div_ID=jQuery(this).attr('id');
            var JIT_PSlider_DSS_Main_Div_slider = new $JssorSlider$(JIT_PSlider_DSS_Main_Div_ID, JIT_PSlider_DSS_Main_Div_options);
            
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var refSize = JIT_PSlider_DSS_Main_Div_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, parseInt(JIT_PSlider_DSS_CW));
                    JIT_PSlider_DSS_Main_Div_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        })
	}
	var JIT_PSlider_ET3=jQuery('#JIT_PSlider_ET3').val();
	if(JIT_PSlider_ET3=='Vertical Thumbnail')
	{
		var JIT_PSlider_VTS_AP=jQuery('#JIT_PSlider_VTS_AP').val();
		var JIT_PSlider_VTS_APS=jQuery('#JIT_PSlider_VTS_APS').val();
		var JIT_PSlider_VTS_CS=jQuery('#JIT_PSlider_VTS_CS').val();
		var JIT_PSlider_VTS_PT=jQuery('#JIT_PSlider_VTS_PT').val();
		var JIT_PSlider_VTS_SS=jQuery('#JIT_PSlider_VTS_SS').val();
		var JIT_PSlider_VTS_AS=jQuery('#JIT_PSlider_VTS_AS').val();
		var JIT_PSlider_VTS_CW=jQuery('#JIT_PSlider_VTS_CW').val().split('px')[0];

		if(JIT_PSlider_VTS_AP=='true')
		{
			JIT_PSlider_VTS_AP_real=true;
		}
		else if(JIT_PSlider_VTS_AP=='false')
		{
			JIT_PSlider_VTS_AP_real=false;
		}

        var JIT_PSlider_VTS_SlideshowTransitions = [
          {$Duration:1200,$Zoom:1,$Easing:{$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad},$Opacity:2},
          {$Duration:1000,$Zoom:11,$SlideOut:true,$Easing:{$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Zoom:1,$Rotate:1,$During:{$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
          {$Duration:1000,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
          {$Duration:1200,x:0.5,$Cols:2,$Zoom:1,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:4,$Cols:2,$Zoom:11,$SlideOut:true,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.6,$Zoom:1,$Rotate:1,$During:{$Left:[0.2,0.8],$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Left:$Jease$.$Swing,$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
          {$Duration:1000,x:-4,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
          {$Duration:1200,x:-0.6,$Zoom:1,$Rotate:1,$During:{$Left:[0.2,0.8],$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Left:$Jease$.$Swing,$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
          {$Duration:1000,x:4,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
          {$Duration:1200,x:0.5,y:0.3,$Cols:2,$Zoom:1,$Rotate:1,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.7}},
          {$Duration:1000,x:0.5,y:0.3,$Cols:2,$Zoom:1,$Rotate:1,$SlideOut:true,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InExpo,$Top:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.7}},
          {$Duration:1200,x:-4,y:2,$Rows:2,$Zoom:11,$Rotate:1,$Assembly:2049,$ChessMode:{$Row:28},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.7}},
          {$Duration:1200,x:1,y:2,$Cols:2,$Zoom:11,$Rotate:1,$Assembly:2049,$ChessMode:{$Column:19},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.8}}
        ];
        
        var JIT_PSlider_VTS_options = {
          $AutoPlay: JIT_PSlider_VTS_AP_real,
          $AutoPlaySteps: parseInt(JIT_PSlider_VTS_APS),
          $Idle: parseInt(JIT_PSlider_VTS_PT),
          $SlideDuration: parseInt(JIT_PSlider_VTS_CS),
          $SlideSpacing: parseInt(JIT_PSlider_VTS_SS),
          $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: JIT_PSlider_VTS_SlideshowTransitions,
            $TransitionsOrder: 1
          },
          $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$,
            $Steps: parseInt(JIT_PSlider_VTS_AS)
          },
          $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $Rows: 2,
            $Cols: 6,
            $SpacingX: 14,
            $SpacingY: 12,
            $Orientation: 2,
            $Align: 156
          }
        };

        jQuery('.JIT_PSlider_VTS').each(function(){
        	
        	var JIT_PSlider_VTS_ID=jQuery(this).attr('id');
            var JIT_PSlider_VTS_slider = new $JssorSlider$(JIT_PSlider_VTS_ID, JIT_PSlider_VTS_options);
            
	        //responsive code begin
	        //you can remove responsive code if you don't want the slider scales while window resizing
	        function ScaleSlider() {
	            var refSize = JIT_PSlider_VTS_slider.$Elmt.parentNode.clientWidth;
	            if (refSize) {
	                refSize = Math.min(refSize, parseInt(JIT_PSlider_VTS_CW));
	                JIT_PSlider_VTS_slider.$ScaleWidth(refSize);
	            }
	            else {
	                window.setTimeout(ScaleSlider, 30);
	            }
	        }
	        ScaleSlider();
	        $(window).bind("load", ScaleSlider);
	        $(window).bind("resize", ScaleSlider);
	        $(window).bind("orientationchange", ScaleSlider);
	        //responsive code end
        })       
	}
	var JIT_PSlider_ET4=jQuery('#JIT_PSlider_ET4').val();
	if(JIT_PSlider_ET4=='Horizontal Thumbnail')
	{
		var JIT_PSlider_HTS_AP=jQuery('#JIT_PSlider_HTS_AP').val();
		var JIT_PSlider_HTS_APS=jQuery('#JIT_PSlider_HTS_APS').val();
		var JIT_PSlider_HTS_CS=jQuery('#JIT_PSlider_HTS_CS').val();
		var JIT_PSlider_HTS_PT=jQuery('#JIT_PSlider_HTS_PT').val();
		var JIT_PSlider_HTS_SS=jQuery('#JIT_PSlider_HTS_SS').val();
		var JIT_PSlider_HTS_AS=jQuery('#JIT_PSlider_HTS_AS').val();
		var JIT_PSlider_HTS_CW=jQuery('#JIT_PSlider_HTS_CW').val().split('px')[0];

		if(JIT_PSlider_HTS_AP=='true')
		{
			JIT_PSlider_HTS_AP_real=true;
		}
		else if(JIT_PSlider_HTS_AP=='false')
		{
			JIT_PSlider_HTS_AP_real=false;
		}

		var JIT_PSlider_HTS_SlideshowTransitions = [
          {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
        ];
        
        var JIT_PSlider_HTS_options = {
          $AutoPlay: JIT_PSlider_HTS_AP_real,
          $AutoPlaySteps: parseInt(JIT_PSlider_HTS_APS),
          $Idle: parseInt(JIT_PSlider_HTS_PT),
          $SlideDuration: parseInt(JIT_PSlider_HTS_CS),
          $SlideSpacing: parseInt(JIT_PSlider_HTS_SS),
          $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: JIT_PSlider_HTS_SlideshowTransitions,
            $TransitionsOrder: 1
          },
          $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$,
            $Steps: parseInt(JIT_PSlider_HTS_AS)
          },
          $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $Cols: 10,
            $SpacingX: 8,
            $SpacingY: 8,
            $Align: 500
          }
        };

        jQuery('.JIT_PSlider_HTS').each(function(){
        	
        	var JIT_PSlider_HTS_ID=jQuery(this).attr('id');
            var JIT_PSlider_HTS_slider = new $JssorSlider$(JIT_PSlider_HTS_ID, JIT_PSlider_HTS_options);
            
	        //responsive code begin
	        //you can remove responsive code if you don't want the slider scales while window resizing
	        function ScaleSlider() {
	            var refSize = JIT_PSlider_HTS_slider.$Elmt.parentNode.clientWidth;
	            if (refSize) {
	                refSize = Math.min(refSize, parseInt(JIT_PSlider_HTS_CW));
	                JIT_PSlider_HTS_slider.$ScaleWidth(refSize);
	            }
	            else {
	                window.setTimeout(ScaleSlider, 30);
	            }
	        }
	        ScaleSlider();
	        $(window).bind("load", ScaleSlider);
	        $(window).bind("resize", ScaleSlider);
	        $(window).bind("orientationchange", ScaleSlider);
	        //responsive code end
        })
	}
	var JIT_PSlider_ET5=jQuery('#JIT_PSlider_ET5').val();
	if(JIT_PSlider_ET5=='Thumbnail Slider')
	{
		var JIT_PSlider_TS_AP=jQuery('#JIT_PSlider_TS_AP').val();
		var JIT_PSlider_TS_APS=jQuery('#JIT_PSlider_TS_APS').val();
		var JIT_PSlider_TS_CS=jQuery('#JIT_PSlider_TS_CS').val();
		var JIT_PSlider_TS_PT=jQuery('#JIT_PSlider_TS_PT').val();
		var JIT_PSlider_TS_SS=jQuery('#JIT_PSlider_TS_SS').val();
		var JIT_PSlider_TS_AS=jQuery('#JIT_PSlider_TS_AS').val();
		var JIT_PSlider_TS_CW=jQuery('#JIT_PSlider_TS_CW').val().split('px')[0];

		if(JIT_PSlider_TS_AP=='true')
		{
			JIT_PSlider_TS_AP_real=true;
		}
		else if(JIT_PSlider_TS_AP=='false')
		{
			JIT_PSlider_TS_AP_real=false;
		}

		var JIT_PSlider_TS_SlideshowTransitions = [
          {$Duration:1500,x:0.5,$Cols:2,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InOutCubic},$Opacity:2,$Brother:{$Duration:1500,$Opacity:2}},
          {$Duration:1500,x:0.3,$During:{$Left:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Opacity:$Jease$.$Linear},$Opacity:2,$Outside:true,$Brother:{$Duration:1000,x:-0.3,$Easing:{$Left:$Jease$.$InQuad,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,x:0.25,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1200,x:-0.1,y:-0.7,$Rotate:0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
          {$Duration:1600,x:1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,x:-1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1600,x:1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,x:-1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1600,y:-1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,y:1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,y:1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1200,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,x:1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1200,x:-1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
          {$Duration:1200,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1200,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Shift:-100}},
          {$Duration:1200,x:1,$Delay:40,$Cols:6,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1200,x:1,$Delay:40,$Cols:6,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$ZIndex:-10,$Shift:-100}},
          {$Duration:1500,x:-0.1,y:-0.7,$Rotate:0.1,$During:{$Left:[0.6,0.4],$Top:[0.6,0.4],$Rotate:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1000,x:0.2,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
          {$Duration:1600,x:-0.2,$Delay:40,$Cols:12,$During:{$Left:[0.4,0.6]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5},$Brother:{$Duration:1000,x:0.2,$Delay:40,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:1028,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Round:{$Top:0.5}}}
        ];

		var JIT_PSlider_TS_options = {
          $AutoPlay: JIT_PSlider_TS_AP_real,
          $AutoPlaySteps: parseInt(JIT_PSlider_TS_APS),
          $Idle: parseInt(JIT_PSlider_TS_PT),
          $SlideDuration: parseInt(JIT_PSlider_TS_CS),
          $SlideSpacing: parseInt(JIT_PSlider_TS_SS),
          $FillMode: 5,
          $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: JIT_PSlider_TS_SlideshowTransitions,
            $TransitionsOrder: 1
          },
          $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$,
            $Steps: parseInt(JIT_PSlider_TS_AS)
          },
          $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $Cols: 9,
            $SpacingX: 3,
            $SpacingY: 3,
            $Align: 260
          }
        };
        jQuery('.JIT_PSlider_TS').each(function(){
        	var JIT_PSlider_TS_ID=jQuery(this).attr('id');
        	var JIT_PSlider_TS_slider = new $JssorSlider$(JIT_PSlider_TS_ID, JIT_PSlider_TS_options);
            
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var refSize = JIT_PSlider_TS_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, parseInt(JIT_PSlider_TS_CW));
                    JIT_PSlider_TS_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        })	
	}
	var JIT_PSlider_ET6=jQuery('#JIT_PSlider_ET6').val();
	if(JIT_PSlider_ET6=='3D Slider')
	{
		var JIT_PSlider_3D_AutoPlay=jQuery('#JIT_PSlider_3D_AutoPlay').val();
		if(JIT_PSlider_3D_AutoPlay=='true')
		{
			JIT_PSlider_3D_AutoPlay_R=true;
		}
		else if(JIT_PSlider_3D_AutoPlay=='false')
		{
			JIT_PSlider_3D_AutoPlay_R=false;
		}
		var JIT_PSlider_3D_SD=jQuery('#JIT_PSlider_3D_SD').val();
		var JIT_PSlider_3D_Deg=jQuery('#JIT_PSlider_3D_Deg').val();

		(function( $, undefined) {
			$.Gallery 				= function( options, element ) {
				this.$el	= $( element );
				this._init( options );
			};

			$.Gallery.defaults 		= {
					current		: 0,	// index of current item
					autoplay	: JIT_PSlider_3D_AutoPlay_R,// slideshow on / off
					interval	: JIT_PSlider_3D_SD  // time between transitions
			    };
			
			$.Gallery.prototype 	= {
				_init 				: function( options ) {
					this.options 		= $.extend( true, {}, $.Gallery.defaults, options );
					// support for 3d / 2d transforms and transitions
					this.support3d		= Modernizr.csstransforms3d;
					this.support2d		= Modernizr.csstransforms;
					this.supportTrans	= Modernizr.csstransitions;
					
					this.$wrapper		= this.$el.find('.JIT_PSlider_3Dwrap');
					
					this.$items			= this.$wrapper.children();
					this.itemsCount		= this.$items.length;
					
					this.$nav			= this.$el.find('nav');
					this.$navPrev		= this.$nav.find('.JIT_PSlider_3DPrev');
					this.$navNext		= this.$nav.find('.JIT_PSlider_3DNext');
					// minimum of 3 items
					if( this.itemsCount < 3 ) {
						this.$nav.remove();
						return false;
					}	
					this.current		= this.options.current;
					this.isAnim			= false;
					this.$items.css({
						'opacity'	: 0,
						'visibility': 'hidden'
					});
					this._validate();
					this._layout();
					// load the events
					this._loadEvents();
					// slideshow
					if( this.options.autoplay ) {
						this._startSlideshow();
					}
				},
				_validate			: function() {
					if( this.options.current < 0 || this.options.current > this.itemsCount - 1 ) {
						this.current = 0;
					}	
				},
				_layout				: function() {
					// current, left and right items
					this._setItems();
					// current item is not changed
					// left and right one are rotated and translated
					var leftCSS, rightCSS, currentCSS;
					if( this.support3d && this.supportTrans ) {
						leftCSS 	= {
							'-webkit-transform'	: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
							'-moz-transform'	: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
							'-o-transform'		: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
							'-ms-transform'		: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
							'transform'			: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')'
						};
						rightCSS	= {
							'-webkit-transform'	: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
							'-moz-transform'	: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
							'-o-transform'		: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
							'-ms-transform'		: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
							'transform'			: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')'
						};
						leftCSS.opacity		= 1;
						leftCSS.visibility	= 'visible';
						rightCSS.opacity	= 1;
						rightCSS.visibility	= 'visible';
					}
					else if( this.support2d && this.supportTrans ) {
						leftCSS 	= {
							'-webkit-transform'	: 'translate(-350px) scale(0.8)',
							'-moz-transform'	: 'translate(-350px) scale(0.8)',
							'-o-transform'		: 'translate(-350px) scale(0.8)',
							'-ms-transform'		: 'translate(-350px) scale(0.8)',
							'transform'			: 'translate(-350px) scale(0.8)'
						};
						rightCSS	= {
							'-webkit-transform'	: 'translate(350px) scale(0.8)',
							'-moz-transform'	: 'translate(350px) scale(0.8)',
							'-o-transform'		: 'translate(350px) scale(0.8)',
							'-ms-transform'		: 'translate(350px) scale(0.8)',
							'transform'			: 'translate(350px) scale(0.8)'
						};
						currentCSS	= {
							'z-index'			: 999
						};
						leftCSS.opacity		= 1;
						leftCSS.visibility	= 'visible';
						rightCSS.opacity	= 1;
						rightCSS.visibility	= 'visible';
					}
					this.$leftItm.css( leftCSS || {} );
					this.$rightItm.css( rightCSS || {} );
					this.$currentItm.css( currentCSS || {} ).css({
						'opacity'	: 1,
						'visibility': 'visible'
					}).addClass('dg-center');
				},
				_setItems			: function() {
					this.$items.removeClass('dg-center');
					this.$currentItm	= this.$items.eq( this.current );
					this.$leftItm		= ( this.current === 0 ) ? this.$items.eq( this.itemsCount - 1 ) : this.$items.eq( this.current - 1 );
					this.$rightItm		= ( this.current === this.itemsCount - 1 ) ? this.$items.eq( 0 ) : this.$items.eq( this.current + 1 );
					if( !this.support3d && this.support2d && this.supportTrans ) {
						this.$items.css( 'z-index', 1 );
						this.$currentItm.css( 'z-index', 999 );
					}
					// next & previous items
					if( this.itemsCount > 3 ) {
						// next item
						this.$nextItm		= ( this.$rightItm.index() === this.itemsCount - 1 ) ? this.$items.eq( 0 ) : this.$rightItm.next();
						this.$nextItm.css( this._getCoordinates('outright') );
						// previous item
						this.$prevItm		= ( this.$leftItm.index() === 0 ) ? this.$items.eq( this.itemsCount - 1 ) : this.$leftItm.prev();
						this.$prevItm.css( this._getCoordinates('outleft') );
					}
				},
				_loadEvents			: function() {
					var _self	= this;
					this.$navPrev.on( 'click.gallery', function( event ) {
						if( _self.options.autoplay ) {
							clearTimeout( _self.slideshow );
							_self.options.autoplay	= false;
						}
						_self._navigate('prev');
						return false;
					});
					this.$navNext.on( 'click.gallery', function( event ) {
						if( _self.options.autoplay ) {
							clearTimeout( _self.slideshow );
							_self.options.autoplay	= false;
						}
						_self._navigate('next');
						return false;
					});
					this.$wrapper.on( 'webkitTransitionEnd.gallery transitionend.gallery OTransitionEnd.gallery', function( event ) {
						_self.$currentItm.addClass('dg-center');
						_self.$items.removeClass('dg-transition');
						_self.isAnim	= false;
					});
				},
				_getCoordinates		: function( position ) {
					if( this.support3d && this.supportTrans ) {
						switch( position ) {
							case 'outleft':
								return {
									'-webkit-transform'	: 'translateX(-450px) translateZ(-300px) rotateY('+JIT_PSlider_3D_Deg+')',
									'-moz-transform'	: 'translateX(-450px) translateZ(-300px) rotateY('+JIT_PSlider_3D_Deg+')',
									'-o-transform'		: 'translateX(-450px) translateZ(-300px) rotateY('+JIT_PSlider_3D_Deg+')',
									'-ms-transform'		: 'translateX(-450px) translateZ(-300px) rotateY('+JIT_PSlider_3D_Deg+')',
									'transform'			: 'translateX(-450px) translateZ(-300px) rotateY('+JIT_PSlider_3D_Deg+')',
									'opacity'			: 0,
									'visibility'		: 'hidden'
								};
								break;
							case 'outright':
								return {
									'-webkit-transform'	: 'translateX(450px) translateZ(-300px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'-moz-transform'	: 'translateX(450px) translateZ(-300px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'-o-transform'		: 'translateX(450px) translateZ(-300px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'-ms-transform'		: 'translateX(450px) translateZ(-300px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'transform'			: 'translateX(450px) translateZ(-300px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'opacity'			: 0,
									'visibility'		: 'hidden'
								};
								break;
							case 'left':
								return {
									'-webkit-transform'	: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
									'-moz-transform'	: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
									'-o-transform'		: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
									'-ms-transform'		: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
									'transform'			: 'translateX(-350px) translateZ(-200px) rotateY('+JIT_PSlider_3D_Deg+')',
									'opacity'			: 1,
									'visibility'		: 'visible'
								};
								break;
							case 'right':
								return {
									'-webkit-transform'	: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'-moz-transform'	: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'-o-transform'		: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'-ms-transform'		: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'transform'			: 'translateX(350px) translateZ(-200px) rotateY(-'+JIT_PSlider_3D_Deg+')',
									'opacity'			: 1,
									'visibility'		: 'visible'
								};
								break;
							case 'center':
								return {
									'-webkit-transform'	: 'translateX(0px) translateZ(0px) rotateY(0deg)',
									'-moz-transform'	: 'translateX(0px) translateZ(0px) rotateY(0deg)',
									'-o-transform'		: 'translateX(0px) translateZ(0px) rotateY(0deg)',
									'-ms-transform'		: 'translateX(0px) translateZ(0px) rotateY(0deg)',
									'transform'			: 'translateX(0px) translateZ(0px) rotateY(0deg)',
									'opacity'			: 1,
									'visibility'		: 'visible'
								};
								break;
						};
					}
					else if( this.support2d && this.supportTrans ) {
						switch( position ) {
							case 'outleft':
								return {
									'-webkit-transform'	: 'translate(-450px) scale(0.7)',
									'-moz-transform'	: 'translate(-450px) scale(0.7)',
									'-o-transform'		: 'translate(-450px) scale(0.7)',
									'-ms-transform'		: 'translate(-450px) scale(0.7)',
									'transform'			: 'translate(-450px) scale(0.7)',
									'opacity'			: 0,
									'visibility'		: 'hidden'
								};
								break;
							case 'outright':
								return {
									'-webkit-transform'	: 'translate(450px) scale(0.7)',
									'-moz-transform'	: 'translate(450px) scale(0.7)',
									'-o-transform'		: 'translate(450px) scale(0.7)',
									'-ms-transform'		: 'translate(450px) scale(0.7)',
									'transform'			: 'translate(450px) scale(0.7)',
									'opacity'			: 0,
									'visibility'		: 'hidden'
								};
								break;
							case 'left':
								return {
									'-webkit-transform'	: 'translate(-350px) scale(0.8)',
									'-moz-transform'	: 'translate(-350px) scale(0.8)',
									'-o-transform'		: 'translate(-350px) scale(0.8)',
									'-ms-transform'		: 'translate(-350px) scale(0.8)',
									'transform'			: 'translate(-350px) scale(0.8)',
									'opacity'			: 1,
									'visibility'		: 'visible'
								};
								break;
							case 'right':
								return {
									'-webkit-transform'	: 'translate(350px) scale(0.8)',
									'-moz-transform'	: 'translate(350px) scale(0.8)',
									'-o-transform'		: 'translate(350px) scale(0.8)',
									'-ms-transform'		: 'translate(350px) scale(0.8)',
									'transform'			: 'translate(350px) scale(0.8)',
									'opacity'			: 1,
									'visibility'		: 'visible'
								};
								break;
							case 'center':
								return {
									'-webkit-transform'	: 'translate(0px) scale(1)',
									'-moz-transform'	: 'translate(0px) scale(1)',
									'-o-transform'		: 'translate(0px) scale(1)',
									'-ms-transform'		: 'translate(0px) scale(1)',
									'transform'			: 'translate(0px) scale(1)',
									'opacity'			: 1,
									'visibility'		: 'visible'
								};
								break;
						};
					}
					else {
						switch( position ) {
							case 'outleft'	: 
							case 'outright'	: 
							case 'left'		: 
							case 'right'	:
								return {
									'opacity'			: 0,
									'visibility'		: 'hidden'
								};
								break;
							case 'center'	:
								return {
									'opacity'			: 1,
									'visibility'		: 'visible'
								};
								break;
						};
					}
				},
				_navigate			: function( dir ) {
					if( this.supportTrans && this.isAnim )
						return false;
					this.isAnim	= true;
					switch( dir ) {
						case 'next' :
							this.current	= this.$rightItm.index();
							// current item moves left
							this.$currentItm.addClass('dg-transition').css( this._getCoordinates('left') );
							// right item moves to the center
							this.$rightItm.addClass('dg-transition').css( this._getCoordinates('center') );	
							// next item moves to the right
							if( this.$nextItm ) {
								// left item moves out
								this.$leftItm.addClass('dg-transition').css( this._getCoordinates('outleft') );
								this.$nextItm.addClass('dg-transition').css( this._getCoordinates('right') );
							}
							else {
								// left item moves right
								this.$leftItm.addClass('dg-transition').css( this._getCoordinates('right') );
							}
							break;
						case 'prev' :
							this.current	= this.$leftItm.index();
							// current item moves right
							this.$currentItm.addClass('dg-transition').css( this._getCoordinates('right') );
							// left item moves to the center
							this.$leftItm.addClass('dg-transition').css( this._getCoordinates('center') );
							// prev item moves to the left
							if( this.$prevItm ) {
								// right item moves out
								this.$rightItm.addClass('dg-transition').css( this._getCoordinates('outright') );
								this.$prevItm.addClass('dg-transition').css( this._getCoordinates('left') );
							}
							else {
								// right item moves left
								this.$rightItm.addClass('dg-transition').css( this._getCoordinates('left') );
							}
							break;	
					};
					this._setItems();
					if( !this.supportTrans )
						this.$currentItm.addClass('dg-center');
				},
				_startSlideshow		: function() {
					var _self	= this;
					this.slideshow	= setTimeout( function() {
						_self._navigate( 'next' );
						if( _self.options.autoplay ) {
							_self._startSlideshow();
						}
					}, this.options.interval );
				},
				destroy				: function() {
					this.$navPrev.off('.gallery');
					this.$navNext.off('.gallery');
					this.$wrapper.off('.gallery');
				}
			};
			var logError 			= function( message ) {
				if ( this.console ) {
					console.error( message );
				}
			};
			$.fn.gallery			= function( options ) {
				if ( typeof options === 'string' ) {
					var args = Array.prototype.slice.call( arguments, 1 );
					this.each(function() {
						var instance = $.data( this, 'gallery' );
						if ( !instance ) {
							logError( "cannot call methods on gallery prior to initialization; " +
							"attempted to call method '" + options + "'" );
							return;
						}
						if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
							logError( "no such method '" + options + "' for gallery instance" );
							return;
						}
						instance[ options ].apply( instance, args );
					});
				} 
				else {
					this.each(function() {
						var instance = $.data( this, 'gallery' );
						if ( !instance ) {
							$.data( this, 'gallery', new $.Gallery( options, this ) );
						}
					});
				}
				return this;
			};
		})( jQuery );
	}
});