jQuery( document ).ready(function() {

	// add submenu icons class in main menu (only for large resolution)
	if (fcorpo_IsLargeResolution()) {
	
		jQuery('#navmain > div > ul > li:has("ul")').addClass('level-one-sub-menu');
		jQuery('#navmain > div > ul li ul li:has("ul")').addClass('level-two-sub-menu');										
	}

	jQuery('#navmain > div').on('click', function(e) {

		e.stopPropagation();

		// toggle main menu
		if (fcorpo_IsSmallResolution() || fcorpo_IsMediumResolution()) {

			var parentOffset = jQuery(this).parent().offset(); 
			
			var relY = e.pageY - parentOffset.top;
		
			if (relY < 36) {
			
				jQuery('ul:first-child', this).toggle(400);
			}
		}
	});

	jQuery("#navmain > div > ul li").mouseleave( function() {
		if (fcorpo_IsLargeResolution()) {
			jQuery(this).children("ul").stop(true, true).css('display', 'block').slideUp(300);
		}
	});
	
	jQuery("#navmain > div > ul li").mouseenter( function() {
		if (fcorpo_IsLargeResolution()) {

			var curMenuLi = jQuery(this);
			jQuery("#navmain > div > ul > ul:not(:contains('#" + curMenuLi.attr('id') + "')) ul").hide();
		
			jQuery(this).children("ul").stop(true, true).css('display','none').slideDown(400);
		}
	});
	
	jQuery(function(){
		jQuery('#camera_wrap').camera({
			height: fcorpo_IsLargeResolution() ? '450px' : '300px',
			loader: 'bar',
			pagination: true,
			thumbnails: false,
			time: 4500
		});
	});
});

function fcorpo_IsSmallResolution() {

	return (jQuery(window).width() <= 360);
}

function fcorpo_IsMediumResolution() {
	
	var browserWidth = jQuery(window).width();

	return (browserWidth > 360 && browserWidth < 800);
}

function fcorpo_IsLargeResolution() {

	return (jQuery(window).width() >= 800);
}

jQuery(document).ready(function () {

  jQuery(window).scroll(function () {
	  if (jQuery(this).scrollTop() > 100) {
		  jQuery('.scrollup').fadeIn();
	  } else {
		  jQuery('.scrollup').fadeOut();
	  }
  });

  jQuery('.scrollup').click(function () {
	  jQuery("html, body").animate({
		  scrollTop: 0
	  }, 600);
	  return false;
  });

});