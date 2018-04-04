<script id="{$htmlId}-script">
 jQuery(window).load(function(){
	{!$el->jsObject}


//	if (!isResponsive(640) && !isMobile()) {

		var element = jQuery('#{$htmlId|noescape}'),
			slidesWrap = element.find('.slides'),
			slides = slidesWrap.find('.slide')
			numSlides = slides.length,
			navigation = jQuery('.slider-navigation'),
			slideDuration = {!$el->jsObjectName}.current.slideDuration;


		// slides.css('opacity', '0');
		slides.first().addClass('active');


		var iterator = 0;


		function changeSlide() {
			if( iterator == numSlides ) iterator = 0;
			if( iterator == -1 ) iterator = numSlides - 1;
			slides.removeClass('active');
			slides.eq(iterator).addClass('active');
		}

		function autoSlide() {
			iterator = iterator + 1;
			changeSlide();
		}

		
		if(isResponsive(640)){
			backgroundSliderHeight();
		}

		var intervalId = setInterval(autoSlide, slideDuration);


		navigation.find('a.navigation-prev').on('click', function(e){
			e.preventDefault();
			clearInterval(intervalId);
			iterator--;
			changeSlide();
			intervalId = setInterval( autoSlide, slideDuration);
		});
		navigation.find('a.navigation-next').on('click', function(e){
			e.preventDefault();
			clearInterval(intervalId);
			iterator++;
			changeSlide();
			intervalId = setInterval( autoSlide, slideDuration);
		});
//	}


jQuery(window).resize(function(){
	if(isResponsive(640)){
		backgroundSliderHeight();
	} else {
		jQuery('#{$htmlId|noescape}').find('.slider-wrap').css({'height': ''});
	}

});

function backgroundSliderHeight(){
	var $container = jQuery('#{$htmlId|noescape}');
	var maxHeight = 0;
	$container.find('.slide').each(function(){
		var $slideinfo = jQuery(this).find('.slide-info');
		if($slideinfo.outerHeight(true) > maxHeight){
			maxHeight = $slideinfo.outerHeight(true);
		}
	});
	$container.find('.slider-wrap').css({'height': maxHeight});
}
});
</script>
