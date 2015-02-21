(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);

    var apiEnjoyInteractBackendUri = '/api/internal/v1/article/enjoy';

    app.controller(editorGlobals.controller.name, [
        '$scope',
        '$http',
        '$location',
        '$window',
        'ArticleApi',
        function ($scope, $http, $location, $window, ArticleApi) {

            //Default variables
            var href = $window.location.href;
            $scope.articleLoading = true;
            $scope.article = {};
            $scope.article.enjoyed = false;
            $scope.pageLoaded = 30;
            $scope.loaderShow = true;
            $scope.showEnjoys = false;
            $scope.moveLeft = false;
            $scope.slug = href.substr(href.lastIndexOf('/') + 1);

            //Collect article API stuff
            var reloadArticleData = function() {
                ArticleApi.get({article_id: $scope.slug}).$promise.then(function(articleData) {
                    var title = '',
                        content = '',
                        user = '',
                        name = '',
                        slug = '',
                        enjoyed = false,
                        enjoys = '';

                    if (articleData) {
                        title = articleData['title'] || '';
                        content = articleData['content'] || '';
                        user = articleData['userName'] || '';
                        name = articleData['last_updated'] || '';
                        slug = articleData['slug'] || '';
                        enjoys = articleData['enjoys'] || '';
                        enjoyed = articleData['user_enjoyed'] || false;
                    }

                    $scope.article = {
                        'title': angular.copy(title),
                        'content': angular.copy(content),
                        'user': angular.copy(user),
                        'name': angular.copy(name),
                        'slug': angular.copy(slug),
                        'enjoyed': angular.copy(enjoyed),
                        'enjoys': angular.copy(enjoys),
                    };

                    setTimeout(function() {
                        $scope.articleLoading = false;
                        $scope.pageLoaded = 60;
                        setTimeout(function() {
                            $scope.loaderShow = false;
                            $scope.$apply();
                        }, 500);
                        $scope.$apply();
                    }, 300);
                });
            }

            reloadArticleData();

            $scope.enjoy = function() {
                $http.post(apiEnjoyInteractBackendUri, {'name': $scope.article.slug}).
                success(function(data, status, headers, config) {
                    $scope.article.enjoyed = !$scope.article.enjoyed;
                    reloadArticleData();
                }).
                error(function(data, status, headers, config) {
                    $scope.article.enjoyed = $scope.article.enjoyed;
                    reloadArticleData();
                });
            };

            $scope.showEnjoySection = function() {
                $scope.moveLeft = !$scope.moveLeft;
                $scope.showEnjoys = !$scope.showEnjoys;
            };

            $scope.closeRightSection = function() {
                var offset = $(".main-container").position().left;
                if(offset >= 300) {
                    $scope.moveLeft = false;
                    $scope.showEnjoys = false;
                    setTimeout(function() {
                        $scope.$apply();
                    }, 200);
                }
            };
        }
    ]);

})();
