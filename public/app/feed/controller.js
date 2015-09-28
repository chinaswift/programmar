(function () {

	'use strict';

	var app = angular.module(feedGlobals.app.name);

	app.controller(feedGlobals.controller.name, [
	  '$scope',
	  '$window',
	  '$timeout',
	  function ($scope, $window, $timeout) {
	  	//Variables
	  	var mdconverter = new Showdown.converter();
	  	$scope.articlesLoading = true;
	  	$scope.loadingMore = false;
	  	$scope.currentPage = 1;

	  	//function for stripping html
	  	function htmlToPlaintext(text) {
			  return text ? String(text).replace(/<[^>]+>/gm, '') : '';
			}

	  	//Function to collect the posts on the home
	  	$scope.collectPosts = function(nextPage)
	  	{
	  		var collectRoute = '/articles/' + $scope.feedType;
	  		$scope.articlesLoading = true;
	  		//if the next page is not collected set it to 1
	  		if (typeof nextPage === "undefined" || nextPage === null) {
			    var nextPage = 1;
			  }

			  //check the pages are not out of the last page when it is above 1
	  		if (nextPage < 1) {
					nextPage = 1;
				} else if (nextPage > $scope.lastPage) {
				  nextPage = $scope.lastPage;
				}

				//collect the results with the page
	  		$.get(collectRoute + '?page=' + nextPage, function(data) {
	  			if(data.error) {
	  				if(data.error == 'auth') {
	  					angular.element('#loginModal').modal('show');
	  				}
	  			}else{
	  				//filter the content
	  				for(var i = 0; i < data.feed.length; i++) {
		  				var text = mdconverter.makeHtml(data.feed[i].content);
		  				text = htmlToPlaintext(text);
		  				text = text.replace(/[^a-z0-9\s]/gi, '');
		  				data.feed[i].contentHTML = text;
		  				data.feed[i].upvotesNext = parseInt(data.feed[i].upvotes) + 1;
		  			}

		  			$scope.articlesLoading = false;
		  			$scope.articles = data.feed;

		  			//work out the pagination
		  			$scope.currentPage = nextPage;
		  			$scope.lastPage = Math.ceil(data.results/10);
		  			if($scope.lastPage < 1){
							$scope.lastPage = 1;
						}

		  			$timeout(function() {
		  				$scope.$apply();
		  			}, 300);
	  			}
	  		});
	  	}

	  	//function which is ran onload
	  	$scope.onload = function()
	  	{
	  		$timeout(function() {
	  			$scope.collectPosts();
	  		}, 300);
	  	};

	  	//run the document onload function
	  	$scope.onload();
	  }
	]);
})();
