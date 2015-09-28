(function () {

	'use strict';

	var app = angular.module(articleGlobals.app.name);

	app.controller(articleGlobals.controller.name, [
	  '$scope',
	  '$window',
	  '$timeout',
	  function ($scope, $window, $timeout) {
	  	//Variables
	  	var mdconverter = new Showdown.converter();
	  	var commentArea = '.comment-text';
	  	$scope.articlesLoading = true;
	  	$scope.article = {};
	  	$scope.currentPage = 1;

	  	$scope.sendADrink = function()
	  	{
	  		if($scope.userData.username != '') {
		  		if($scope.userData.id == $scope.article.owner_id) {
		  			if($scope.article.allow_drink > 0) {
		  				angular.element('#ownArticleDrink').modal('show');
		  			}else{
		  				angular.element('#activateArticleDrink').modal('show');
		  			}
		  		}else{
		  			if($scope.article.allow_drink > 0) {
			  			angular.element('#paymentModal').modal('show');
			  		}else{
			  			angular.element('#notActiveDrink').modal('show');
			  		}
		  		}
		  	}else{
		  		angular.element('#loginModal').modal('show');
		  	}
	  	}

	  	//Function to load the article data
	  	$scope.collectArticle = function()
	  	{
	  		$.get('/articles/collect/' + $scope.article.id, function(data) {
	  			var $content = angular.element('.content');
	  			$scope.article = data.feed[0];
	  			data.feed[0].upvotesNext = parseInt(data.feed[0].upvotes) + 1;

	  			//if you can pay the developer
	  			if($scope.article.allow_drink > 0) {
	  				$scope.setupStripe();
	  			}

	  			$scope.articlesLoading = false;
	  			$(commentArea).mention({
					    delimiter: '@',
					    users: $scope.searchedUsers,
					});
	  			$content.html(mdconverter.makeHtml($scope.article.content));
	  			$timeout(function() {
	  				$scope.$apply();
	  				//console.log($scope.article);
	  			}, 300);
	  		});
	  	}

	  	//function to share with facebook
	  	$scope.facebookShare = function()
	  	{
	  		fbShare('https://programmar.io/articles/' + $scope.article.id, 'Fb Share', $scope.article.name, 'http://goo.gl/dS52U', 520, 350);
	  	}

	  	//function to share with twitter
	  	$scope.twitterShare = function()
	  	{
  			var width  = 575,
		        height = 400,
		        left   = ($(window).width()  - width)  / 2,
		        top    = ($(window).height() - height) / 2,
		        opts   = 'status=1' +
		                 ',width='  + width  +
		                 ',height=' + height +
		                 ',top='    + top    +
		                 ',left='   + left;

		    if($scope.userData.username != '' && $scope.userData.username == $scope.article.owner_user) {
		    	var  url    = 'http://twitter.com/share?text=I just wrote an article on @_programmar&url=https://programmar.io/articles/' + $scope.article.id
		    }else{
		    	var url    = 'http://twitter.com/share?text=I just read an article on @_programmar&url=https://programmar.io/articles/' + $scope.article.id
		    }

		    window.open(url, 'twitter', opts);
		    return false;
	  	}

	  	//function to comment on article
	  	$scope.commentPost = function()
	  	{
	  		$('.comment-text').attr('disabled', 'disabled');
	  		if($scope.userData.username == '') {
	  			angular.element('#loginModal').modal('show');
	  		}else{
	  			$('.comment-text').val('Posting...');
		  		$.post('/articles/comment', {'article_id':$scope.article.id, 'comment':$scope.comment}, function(data) {
		  			$('.comment-btn').html('Comment');
		  			$scope.commentCollect();
		  			$('.comment-text').removeAttr('disabled');
		  			$scope.comment = '';
		  			$('.comment-text').val('');
		  			$timeout(function() {
		  				$scope.$apply();
		  			}, 300);
		  		});
	  		}
	  	}

	  	$scope.commentCollect = function(nextPage)
	  	{
	  		if (typeof nextPage === "undefined" || nextPage === null) {
			    var nextPage = 1;
			  }

			  //check the pages are not out of the last page when it is above 1
	  		if (nextPage < 1) {
					nextPage = 1;
				} else if (nextPage > $scope.lastPage) {
				  nextPage = $scope.lastPage;
				}

	  		$.post('/articles/collectComments', {'article_id':$scope.article.id, 'page': nextPage}, function(data) {
	  			$scope.comments = data.feed;

	  			for (var i = 0; i < data.feed.length; i++) {
	  				var comment = data.feed[i];
	  				var mentionArray = comment.mentions.split(',');
	  				for (var o = 0; o < mentionArray.length; o++) {
	  					comment.content = comment.content.replace('@' + mentionArray[o], '<a href="/users/' + mentionArray[o] + '">@' + mentionArray[o] + '</a>')
	  				}
	  			}

	  			//work out the pagination
	  			$scope.currentPage = nextPage;
	  			$scope.lastPage = Math.ceil(data.results/5);
	  			if($scope.lastPage < 1){
						$scope.lastPage = 1;
					}

	  			$timeout(function() {
	  				$scope.$apply();
	  			}, 300);
	  		});
	  	}

	  	//function which is ran onload
	  	$scope.onload = function()
	  	{
	  		$timeout(function() {
	  			$scope.collectArticle();
	  			$scope.commentCollect();
	  		}, 300);
	  	};

	  	//run the document onload function
	  	$scope.onload();
	  }
	]);
})();
