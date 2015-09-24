(function () {

	'use strict';

	var app = angular.module(notificationsGlobals.app.name);

	app.controller(notificationsGlobals.controller.name, [
	  '$scope',
	  '$window',
	  '$timeout',
	  function ($scope, $window, $timeout) {
	  	//Variables
	  	$scope.notificationsLoading = true;
	  	//function to load all nofitications
	  	$scope.loadAllNotifications = function()
	  	{
	  		$scope.notificationsLoading = true;
	  		$.get('/user/allNotifications', function(data) {
	  			$scope.allNotifications = data;
	  			console.log(data);
	  			$scope.notificationsLoading = false;
	  			$timeout(function() {
	  				$scope.$apply();
	  			}, 300);
	  		});
	  	}

	  	//function to update notifications
	  	$scope.updateNotifications = function()
	  	{
	  		$.get('/user/readNotifications', function(data) {
	  			$scope.loadNotifications();
	  		});
	  	}

	  	//function which is ran onload
	  	$scope.onload = function()
	  	{
	  		$scope.updateNotifications();
	  		$scope.loadAllNotifications();
	  	};

	  	//run the document onload function
	  	$scope.onload();
	  }
	]);
})();
