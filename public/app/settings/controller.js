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
	  			$scope.settings.drinkprice = $scope.userData.drink_price;
	  			$scope.settings.drinkcurrency = $scope.userData.currency;
	  			$timeout(function() {
	  				$scope.$apply();
	  			}, 300);
	  		});
	  	}

	  	$scope.updateDrinkSettings = function()
	  	{
	  		angular.element('.update-btn').text('Updating...');
	  		$.post('/user/update', $scope.settings, function(data) {
	  			if(data.error) {
	  				angular.element('.update-btn').text('Update');
	  				$scope.showMessage('error', data.error);
	  			}else{
	  				angular.element('.update-btn').text('Updated!');
		  			$timeout(function() {
		  				angular.element('.update-btn').text('Update');
		  			}, 3000);
	  			}

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
