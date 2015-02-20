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

            $scope.article = {};
            $scope.article.enjoyed = false;

            //Collect article API stuff
            ArticleApi.query().$promise.then(function(articleData) {
                var title = '',
                    content = '',
                    user = '',
                    name = '',
                    enjoyed = false;

                if (articleData) {
                    title = articleData['title'] || '';
                    content = articleData['content'] || '';
                    user = articleData['userName'] || '';
                    name = articleData['last_updated'] || '';
                    enjoyed = articleData['user_enjoyed'] || false;
                }

                $scope.article = {
                    'title': angular.copy(title),
                    'content': angular.copy(content),
                    'user': angular.copy(user),
                    'name': angular.copy(name),
                    'enjoyed': angular.copy(enjoyed)
                };

                $scope.loading = false;

                setTimeout(function() {
                    $scope.$apply();
                }, 300);
            });

            $scope.enjoy = function(slug) {
                $http.post(apiEnjoyInteractBackendUri, {'name': slug}).
                success(function(data, status, headers, config) {
                    $scope.article.enjoyed = !$scope.article.enjoyed;
                }).
                error(function(data, status, headers, config) {
                    $scope.article.enjoyed = $scope.article.enjoyed;
                });
            };

            //Default variables
            $scope.loading = true;
        }
    ]);

})();
