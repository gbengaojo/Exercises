jQuery(document).ready(function($) {
	$('.mini_cart_item').addClass('clear');

	$('.header-search a').click(function() {
		$('.search-box').addClass('active');
	});

	$('.search-box .close').click(function() {
		$('.search-box').removeClass('active');
	});

	$('#section-product1 .new-prod-slide').slick({
		dots: false,
		infinite: true,
		speed: 300,
		variableWidth: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3,
				infinite: true,
				dots: true
			}
		},
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 1,
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
			}
		}
		]
	});

	$('#section-product2 .new-prod-slide').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		variableWidth: true,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
			}
		}
		]
	});

	$('.feature-cat-product').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
			}
		}
		]
	});

	$('.blog-wrap, .testimonial-wrap').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		slidesToScroll: 1,
	});

	//new WOW().init();

    $('#es-top').css('right', -65);
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('#es-top').css('right', 20);
        } else {
            $('#es-top').css('right', -65);
        }
    });

    $("#es-top").click(function () {
        $('html,body').animate({scrollTop: 0}, 600);
    });

    $(".various").fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
	});

	$('.cat-parent').hover(function(){
		$(this).children('ul.children').slideToggle(500);
	});
	
});//document.ready close