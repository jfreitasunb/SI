/**
 * Created by phelippe on 21/10/18.
 */

$( function() {
	$(window).resize(function() {
		resizeContent();
	});

	function resizeContent() {
		var cw = $('.big').height();
		$(".height").height(cw - 96 - 46);
	}

	function isNumber (o) {
		return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
	}

	resizeContent();
});
