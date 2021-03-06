(function () {

	'use strict';

	var app = angular.module(appGlobals.app.name);
	var upvoteAPIRoute = '/articles/upvote';

	app.controller(appGlobals.controller.name, [
	  '$scope',
	  '$window',
	  '$timeout',
	  'UserData',
	  function ($scope, $window, $timeout, UserData) {
	  	//Variables
	  	var messagesSelector = '.messages';
	  	var upvoteSelector = "#upvote";
	  	var form = $('[name="cardForm"]');

	  	$scope.writeDropdownLoading = true;
	  	$scope.writeDropdownDrafts = [];
	  	$scope.userData = {};
	  	$scope.userData.username = '';
	  	$scope.userData.loaded = false;
	  	$scope.notifications = {};
	  	$scope.hits = [];
	    $scope.query = '';
	    $scope.drinkPayment = {};
	    $scope.initRun = true;
	    $scope.stripeSending = false;

	    //function to handel stripe errors
	    $scope.stripeResponse = function(status, response)
	    {
	    		if(response.error) {
	    			$scope.stripeSending = false;
	    			$scope.showMessage('error', response.error.message);
	    		}else{
	    			$scope.drinkPayment.token = response.id;
	    			//send the form data to the api
	    			$.post('/connect/bill', $scope.drinkPayment, function(data) {
	    				$scope.stripeSending = false;
	    				var info = data.split(':');
	    				var messageType = info[0];
	    				var message = info[1];
	    				if(messageType == 'error') {
	    					$scope.showMessage('error', message);
	    				}else{
	    					$scope.showMessage('success', "You've sent this person a drink!");
	    					angular.element("#paymentModal").modal('hide');
	    				}
	    			});
	    		}

	    		$timeout(function() {
		  			$scope.$apply();
		  		}, 300);
	    }

	    //function to handel stripe payment
	  	$scope.handlePayment = function(sendToId)
	  	{
	  		$scope.drinkPayment.to_id = sendToId;
	  		$scope.stripeSending = true;
	  		Stripe.createToken(form, $.proxy($scope.stripeResponse, this));
	  		$timeout(function() {
	  			$scope.$apply();
	  		}, 300);
	  	}

	  	//Function to setup stripe
	  	$scope.setupStripe = function()
	  	{
	  		var stripeKey = $('meta[name="stripe_publishable"]').attr('content');
				Stripe.setPublishableKey(stripeKey);
	  	}

	  	//function for displaying messages
	  	$scope.showMessage = function(messageType, messageText)
	  	{
	  		var $message = angular.element(messagesSelector);
	  		$message.attr('class', 'messages');
	  		$message.addClass('messages-' + messageType);
	  		$message.html(messageText);
	  		$message.addClass('show');
	  		$timeout(function() {
	  			$message.removeClass('show');
	  		}, 3000);
	  	}

	  	//function to search articles
	  	$scope.searchQuery = function() {
	  		var query = angular.element('.modal-input').val();

	      $.get('/search?limit=2&query=' + query, function(data) {
	      	$scope.articleSearchResults = data.articles;
	      	$scope.userSearchResults = data.users;
	      	$timeout(function() {
	      		$scope.$apply();
	      	}, 300);
	      });
	    };

	    //function to follow user
	    $scope.followUser = function(userId)
	    {
	    	if($scope.userData.username != '') {
		    	$.post('/user/follow', {'id':userId}, function(data) {
		    		console.log(data);
		    		if(data.error) {
		  				var error = data.error;
		  				$scope.showMessage('error', error);
		  			}else{
		  				angular.element('.follow-btn').hide();
		  				angular.element('.unfollow-btn').show();
		  			}
		    	});
		    }else{
		    	angular.element('#loginModal').modal('show');
		    }
	    }

	    $scope.unfollowUser = function(userId)
	    {
	    	if($scope.userData.username != '') {
		    	$.post('/user/unfollow', {'id':userId}, function(data) {
		    		console.log(data);
		    		if(data.error) {
		  				var error = data.error;
		  				$scope.showMessage('error', error);
		  			}else{
		  				angular.element('.follow-btn').show();
		  				angular.element('.unfollow-btn').hide();
		  			}
		    	});
		    }else{
		    	angular.element('#loginModal').modal('show');
		    }
	    }

	    //function to launch the search
	    $scope.searchSite = function()
	    {
	    	angular.element('#searchModal').modal('show');
	    	$timeout(function() {
					angular.element('.modal-input').focus();
	    	}, 300);
	    }

	    //function to search users
	  	$scope.searchUsers = function() {
	      $.get('/search?article=no', function(data) {
	      	$scope.searchedUsers = data.users;
	      	$timeout(function() {
	      		$scope.$apply();
	      	}, 300);
	      });
	    };

	  	//Function to load the users drafts
	  	$scope.loadDrafts = function(limit)
	  	{
		  		if($scope.writeDropdownLoading) {
		  			$.get('/articles/drafts?limit=' + limit, function(data) {
			  			$scope.writeDropdownLoading = false;
			  			$scope.writeDropdownDrafts = data.feed;
			  			$timeout(function() {
			  				$scope.$apply();
			  			}, 300);
			  		});
		  		}
	  	}

	  	//Function when you upvote an article
	  	$scope.upvoteArticle = function(articleId)
	  	{
	  		if($scope.userData.username != '') {
	  			var $upvote = angular.element(upvoteSelector + articleId);
		  		if(!$upvote.hasClass('voted')) {
			  		$.post(upvoteAPIRoute, {'article': articleId}, function(data){
			  			if(data.error) {
			  				var error = data.error[Object.keys(data.error)[0]]
			  				$scope.showMessage('error', error);
			  			}
			  		});
			  	}
		  		$upvote.addClass('voted');
	  		}else{
	  			angular.element('#loginModal').modal('show');
	  		}

	  	}

	  	//function to load notifications
	  	$scope.loadNotifications = function()
	  	{
	  		$.get('/user/notifications', function(data) {
	  			$scope.notifications = data;
	  			console.log(data);
	  			$timeout(function() {
	  				$scope.$apply();
	  			}, 300);
	  		});
	  	}

	  	//function to collect user data
	  	$scope.loadUserData = function()
      {
          UserData.query().$promise.then(function (userData) {
              $scope.userData = userData;
              $scope.userData.loaded = true;
              if($scope.userData.username != '') {
              	$scope.loadNotifications();
              }
              $timeout(function() {
                  $scope.$apply();
              }, 300);
          });
      };

	  	//function which is ran onload
	  	$scope.onload = function()
	  	{
	  		$scope.loadUserData();
	  		$scope.searchUsers();
	  	};

	  	//run the document onload function
	  	$scope.onload();
	  }
	]);
})();