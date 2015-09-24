(function () {

	'use strict';

	var app = angular.module(writeGlobals.app.name);
	var postAPIRoute = '/write/edit';

	app.controller(writeGlobals.controller.name, [
	  '$scope',
	  '$window',
	  '$timeout',
	  function ($scope, $window, $timeout) {
	  	//Variables
	  	var textareaSelector = '#editor';
	  	var saveBtnSelector = '.save-btn';
	  	var publishBtnSelector = '.publish-btn';
	  	var editbarSelector = '.editbar';
			var previewBtnSelector = '.preview-toggle';
			var editorSelector = '#editor';
			var previewSelector = '#preview';
			var previewToggleSelector = '.preview-toggle';
			var myTextArea = document.querySelector('#editor');
			var mdconverter = new Showdown.converter();
			var editor = new Editor(myTextArea);

	  	$scope.article = {};
	  	$scope.articleLoading = true;

	  	//function to save the article
	  	$scope.saveArticle = function()
	  	{
	  		var $saveBtn = angular.element(saveBtnSelector);
	  		$saveBtn.text('Saving...');
	  		$.post(postAPIRoute, $scope.article, function(data) {
	  			if(data.error) {
	  				$saveBtn.text('Save as draft');
	  				var error = data.error[Object.keys(data.error)[0]]
	  				$scope.showMessage('error', error);
	  			}else{
	  				$saveBtn.text('Saved!');
	  				$scope.article.id = data.article_id;
	  				$timeout(function() {
	  					$saveBtn.text('Save as draft');
	  				}, 3000);
	  			}
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
		        url    = 'http://twitter.com/share?text=I just wrote an article on @_programmar&url=https://programmar.io/articles/' + $scope.article.id,
		        opts   = 'status=1' +
		                 ',width='  + width  +
		                 ',height=' + height +
		                 ',top='    + top    +
		                 ',left='   + left;

		    window.open(url, 'twitter', opts);
		    return false;
	  	}

	  	//function to publish an article
	  	$scope.publish = function()
	  	{
	  		var $publishBtn = angular.element(publishBtnSelector);
	  		$publishBtn.text('Publishing...');
	  		$.post('/write/publish', $scope.article, function(data) {
	  			if(data.error) {
	  				$publishBtn.text('Publish');
	  				var error = data.error[Object.keys(data.error)[0]]
	  				$scope.showMessage('error', error);
	  			}else{
	  				$publishBtn.text('Published!');
	  				$scope.article.id = data.article_id;
	  				var $editor = $(editorSelector);
						var $preview = $(previewSelector);

						$preview.html(mdconverter.makeHtml($editor.val()));

				  	$editor.hide();
				  	angular.element('.tags-bar').fadeOut(300);
				  	angular.element('.editbar').fadeOut(300);
				  	angular.element('#publishedModal').modal('show');
				  	angular.element('.title--input').attr('disabled', 'disabled');
				  	$preview.fadeIn(200);
	  			}
	  		});
	  	}

	  	//function to load the article
	  	$scope.loadArticle = function()
	  	{
	  		$timeout(function() {
	  			$.get('/articles/edit/collect?id=' + $scope.article.id, function(data) {
	  				$scope.article = data.feed[0];
	  				$scope.articleLoading = false;
	  				$timeout(function() {
	  					var $ele = angular.element(textareaSelector);
	  					$ele.val($scope.article.content);
	  				}, 300);
	  			});
  			}, 300);
	  	}

	  	//function which is ran onload
	  	$scope.onload = function()
	  	{
	  		$timeout(function() {
	  			if($scope.article.id > 0) {
	  				$scope.loadArticle();
	  			}else{
	  				$scope.articleLoading = false;
	  			}
	  		}, 300);
	  	};

	  	//run the document onload function
	  	$scope.onload();
	  }
	]);
})();
