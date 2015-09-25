(function () {

	'use strict';

	var app = angular.module(settingsGlobals.app.name);

	app.controller(settingsGlobals.controller.name, [
	  '$scope',
	  '$window',
	  '$timeout',
	  function ($scope, $window, $timeout) {
	  	//Variables
	  	$scope.settingsLoading = true;
	  	$scope.settings = {};

	  	//Function to check your connected accounts
	  	$scope.checkConnectedAccounts = function()
	  	{
	  		$.get('/connect/check', function(data) {
	  			$scope.stripeConnect = data.success;
	  			$scope.settingsLoading = false;
	  			$timeout(function() {
	  				$scope.$apply();
	  			}, 300);
	  		});
	  	}

	  	$scope.updateDrinkSettings = function()
	  	{
	  		$.post('/user/update', $scope.settings, function(data) {
	  			console.log(data);
	  		});
	  	}

	  	$scope.disconnectStripe = function()
	  	{
	  		$.get('/connect/disconnect', function(data) {
	  			$scope.stripeConnect = data.success;
	  			$scope.settingsLoading = false;
	  			$timeout(function() {
	  				$scope.$apply();
	  			}, 300);
	  		});
	  	}

	  	//function which is ran onload
	  	$scope.onload = function()
	  	{
	  		$scope.checkConnectedAccounts();
	  	};

	  	//run the document onload function
	  	$scope.onload();
	  }
	]);
})();
