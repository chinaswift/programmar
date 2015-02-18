(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);

    app.controller(editorGlobals.controller.name, [
        '$scope',
        '$http',
        '$location',
        '$window',
        'ArticleApi',
        function ($scope, $http, $location, $window, ArticleApi) {

            $scope.article = {};

            //Collect article API stuff
            ArticleApi.query().$promise.then(function(articleData) {
                var title = '',
                    content = '',
                    user = '',
                    name = '';

                if (articleData) {
                    title = articleData['title'] || '';
                    content = articleData['content'] || '';
                    user = articleData['userName'] || '';
                    name = articleData['last_updated'] || '';
                }

                $scope.article = {
                    'title': angular.copy(title),
                    'content': angular.copy(content),
                    'user': angular.copy(user),
                    'name': angular.copy(name)
                };

                $scope.loading = false;

                setTimeout(function() {
                    $scope.$apply();
                }, 300);
            });


            //Default variables
            $scope.loading = true;

        }
    ]);

})();
