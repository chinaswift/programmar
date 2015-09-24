var profileDropdown = function($) {

	//Variables
	var dropdownClickSelector = '.profile--dropdown',
		writeDropdownClickSelector = '.write--dropdown',
		mobileMenuBtn = '.menu-btn';

	//Function to toggle dropdown
	var toggleDropdown = function(event)
	{
		if(event.type == 'click') {
				event.preventDefault();
				event.stopPropagation();
		}

		var $profileDropdown = $(this),
			$dropdown = $profileDropdown.next('.dropdown'),
			imageAnimateInClass = 'clickIn',
			$clickprofileDropdown = $(dropdownClickSelector),
			$writeDropdown = $(writeDropdownClickSelector)
			$wdropdown = $writeDropdown.next('.dropdown'),
			$pdropdown = $clickprofileDropdown.next('.dropdown');

		if($profileDropdown.hasClass('profile--dropdown') && $writeDropdown.is(":visible")) {
			$wdropdown.fadeOut(150);
		}

		if($profileDropdown.hasClass('write--dropdown') && $profileDropdown.is(":visible")) {
			$pdropdown.fadeOut(150);
		}

		if($dropdown.is(':hidden')) {
			$profileDropdown.addClass(imageAnimateInClass);
			setTimeout(function() {
				$dropdown.fadeIn(300, function() {
					$profileDropdown.removeClass(imageAnimateInClass);
				});
			}, 150);
		}else{
			$profileDropdown.addClass(imageAnimateInClass);
			$dropdown.fadeOut(150);
			setTimeout(function() {
				$profileDropdown.removeClass(imageAnimateInClass);
			}, 400);
		}
	}

	//Function to toggle mobile menu
	var toggleMobileMenu = function(event)
	{
		event.preventDefault();

		var $mobileMenu = $('.mobile-menu'),
			showClass = 'show';

		if($mobileMenu.hasClass(showClass)) {
			$mobileMenu.removeClass(showClass);
		} else {
			$mobileMenu.addClass(showClass);
		}
	}

	var ignition = function()
	{
		var $document = $(document);
		$document.on('click', dropdownClickSelector, toggleDropdown);
		$document.on('click', writeDropdownClickSelector, toggleDropdown);
		$document.on('click', mobileMenuBtn, toggleMobileMenu);
	}

	return {
		'start': ignition,

	}


}(jQuery);

$(document).ready(function() {
	profileDropdown.start();
});