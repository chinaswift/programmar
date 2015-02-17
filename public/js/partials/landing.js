var LandingApplication = (function($) {

	var typingElement = '.type-section';
	var homeString = ['Welcome to Programmar,<br>A place where you can read and write about development.'];


	var startTyping = function() {
		$(typingElement).typed({
		    strings: homeString,
		    contentType: 'html',
		    showCursor: false,
		});
	};

	var ignition = function() {
		startTyping();
	};

	return {
		'start': ignition
	};

})(jQuery);

$(document).ready(function() {
	LandingApplication.start();
});