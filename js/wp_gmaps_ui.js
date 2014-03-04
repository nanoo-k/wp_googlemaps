// This function resizes the google map so that it is 90% the height of the browser. You can write your own function to do this, you can also use this function to resize other elements when the browser window changes.
function responsiveHeight(element, resize) {
	var window_size = $(window).height();
	window_size = window_size*resize;
	$(element).height(window_size);
}

// The functions below are not necessary. I use them on my example page to hide and show the map description. I accomplish this by swapping Bootstrap CSS classes and toggling height and width properties. Example can be found at www.americawasnotfree.org/category/the-conquest
function mapDescriptionHeight(function_to_call, h, element, resize) {
	var w = window.innerWidth;
	if ( w <= 768 ) {
		$(element).height(h);
	} else {
		function_to_call(element, resize);
	}
}
function mapdescription_toggle(){
	var w = window.innerWidth;
	if ( w >= 768 ) {
		var height = $('#description').height();
		$('#map_btn').toggleClass("col-sm-24").toggleClass("col-sm-2");
		$('#map_description').toggleClass("col-sm-8").toggleClass("col-sm-1");
		$('#map_canvas').toggleClass("col-sm-16").toggleClass("col-sm-23");
		switch (height)
		{
			case (1):
				$('#description').toggleClass("col-sm-22").width('').height('100%');
				$('#map_btn').val('\u25B6');
				break;
			default:
				$('#description').toggleClass("col-sm-22").height(1).width(0);
				$('#map_btn').val('\u25C0');
				setTimeout(function(){google.maps.event.trigger(map, "resize");},500);
		}
	
	} else {
		var height = $('#description').height();
		$('#map_btn').toggleClass("col-sm-24").toggleClass("col-sm-2");
		$('#map_description').toggleClass("col-sm-8").toggleClass("col-sm-1");
		$('#map_canvas').toggleClass("col-sm-16").toggleClass("col-sm-23");
		switch (height)
		{
			case (1):
				$('#description').toggleClass("col-sm-22").width('').height('');
				$('#map_description').height('30em');
				$('#map_btn').val('\u25B2');
				break;
			default:
				$('#description').toggleClass("col-sm-22").width('').height(1);
				$('#map_btn').val('\u25BC');
				$('#map_description').height('1.7em');
				setTimeout(function(){google.maps.event.trigger(map, "resize");},500);
		}
	}
}