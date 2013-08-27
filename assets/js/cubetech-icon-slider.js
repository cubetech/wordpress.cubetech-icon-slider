jQuery(function() {

	var cubetechTimeOut;
	jQuery('.cubetech-icon-slider').mouseover( function() {
		clearTimeout(cubetechTimeOut);
	});
	jQuery('.cubetech-icon-slider').mouseout( function() {
		cubetechTimeOut = setTimeout(cubetechShowDiv, 2500);
	});
	jQuery('.cubetech-icon-slider-content').mouseover( function() {
		clearTimeout(cubetechTimeOut);
	});
	jQuery('.cubetech-icon-slider-content').mouseout( function() {
		cubetechTimeOut = setTimeout(cubetechShowDiv, 2500);
	});

	cubetechShowDiv();
	
	jQuery('.cubetech-icon-slider-slide').first().fadeIn();
	jQuery('.cubetech-icon-slider-thumb-second').first().fadeIn();
	jQuery('.cubetech-icon-slider-thumb-active-icon').first().addClass('cubetech-icon-slider-thumb-active');
	jQuery('.cubetech-icon-slider-icon').first().addClass('cubetech-icon-slider-active');

	function cubetechShowDiv() {
	    if(jQuery('.cubetech-icon-slider-slide').length) {
	    	var cubetechID = jQuery('.cubetech-icon-slider-slide:visible').index();
	    	
	    	jQuery('.cubetech-icon-slider-slide').fadeOut(100);
	    	jQuery('.cubetech-icon-slider-thumb-second').fadeOut(100);
	    	jQuery('.cubetech-icon-slider-thumb-active-icon').removeClass('cubetech-icon-slider-thumb-active');
	    	jQuery('.cubetech-icon-slider-icon').removeClass('cubetech-icon-slider-active');
	    	
	    	if (jQuery('.cubetech-icon-slider-slide').length == cubetechID + 1) var cubetechID = -1;
	    	
	    	jQuery('.cubetech-icon-slider-slide').eq(cubetechID + 1).fadeIn(200);
	    	jQuery('.cubetech-icon-slider-thumb-second').eq(cubetechID + 1).fadeIn(200);
	    	jQuery('.cubetech-icon-slider-thumb-active-icon').eq(cubetechID + 1).addClass('cubetech-icon-slider-thumb-active');
	    	jQuery('.cubetech-icon-slider-icon').eq(cubetechID + 1).addClass('cubetech-icon-slider-active');
	    	
	        cubetechTimeOut = setTimeout(cubetechShowDiv, 5000);
	    }
	}
	
	jQuery('li.cubetech-icon-slider-icon').hover(function() {
		var cubetechHoverID = jQuery(this).index();
		jQuery('.cubetech-icon-slider-slide').not(':eq(' + cubetechHoverID + ')').fadeOut(100);
		jQuery('.cubetech-icon-slider-thumb-second').not(':eq(' + cubetechHoverID + ')').fadeOut(100);
		jQuery('.cubetech-icon-slider-thumb-active-icon').not(':eq(' + cubetechHoverID + ')').removeClass('cubetech-icon-slider-thumb-active');
		jQuery('.cubetech-icon-slider-icon').not(':eq(' + cubetechHoverID + ')').removeClass('cubetech-icon-slider-active');

		jQuery('.cubetech-icon-slider-slide').eq(cubetechHoverID).fadeIn(200);
		jQuery('.cubetech-icon-slider-thumb-second').eq(cubetechHoverID).fadeIn(200);
		jQuery('.cubetech-icon-slider-thumb-active-icon').eq(cubetechHoverID).addClass('cubetech-icon-slider-thumb-active');
		jQuery('.cubetech-icon-slider-icon').eq(cubetechHoverID).addClass('cubetech-icon-slider-active');
	});

});