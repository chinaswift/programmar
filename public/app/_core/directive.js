(function () {

    'use strict';

    var app = angular.module(appGlobals.app.name);

    app.directive('setClassWhenAtTop', function ($window) {
	  var $win = angular.element($window); // wrap window object as jQuery object

	  return {
	    restrict: 'A',
	    link: function (scope, element, attrs) {
	      var topClass = attrs.setClassWhenAtTop, // get CSS class from directive's attribute value
	          offsetTop = element.offset().top - 50; // get element's offset top relative to document

	      $win.on('scroll', function (e) {
	        if (($win.scrollTop()) >= offsetTop) {
	          element.addClass(topClass);
	        } else {
	          element.removeClass(topClass);
	        }
	      });
	    }
	  };
	});


	app.directive('setClassWhenAtTopHack', function ($window) {
	  var $win = angular.element($window); // wrap window object as jQuery object

	  return {
	    restrict: 'A',
	    link: function (scope, element, attrs) {
	      var topClass = attrs.setClassWhenAtTopHack, // get CSS class from directive's attribute value
	          offsetTop = element.offset().top; // get element's offset top relative to document

	      $win.on('scroll', function (e) {
	        if (($win.scrollTop() + 275) >= offsetTop) {
	          element.addClass(topClass);
	        } else {
	          element.removeClass(topClass);
	        }
	      });
	    }
	  };
	});

})();
