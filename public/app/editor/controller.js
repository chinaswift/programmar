(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);
    var apiEditorInteractBackendUri = '/api/internal/v1/editor/save';

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
                    name = '',
                    user = '';

                if (articleData) {
                    title = articleData['title'] || '';
                    content = articleData['content'] || '';
                    name = articleData['slug'] || '';
                    user = articleData['userName'] || '';
                }

                $scope.article = {
                    'title': angular.copy(title),
                    'content': angular.copy(content),
                    'name': angular.copy(name),
                    'user': angular.copy(user)
                };
            });


            //Default variables
            $scope.saving = false;
            $scope.loading = true;
            $scope.callbackMsg = false;
            $scope.lastSaveTime = false;
            var saveDelay = 30 * 1000; //5 seconds (ms)

            //Apply initialised variables
            setTimeout(function() {
                $scope.loading = false;
                $scope.$apply();
            }, 300);

            //Auto saving
            setTimeout(function() {
                $scope.saveDocument();
            }, 1000);


            //Word counting function
            $scope.countOf = function(text) {
                var s = text ? text.split(/\s+/) : 0;
                return s ? s.length : '';
            };

            //Function for saving the document
            $scope.saveDocument = function() {
                var title = $scope.article.title,
                    content = $scope.article.content,
                    name = $scope.article.name,
                    currentTime = new Date();

                //make sure the title or content has been edited
                if(title != '' || content != '') {
                    //If first edit, or its been longer than the delayed time.
                    if(!$scope.lastSaveTime || (currentTime - $scope.lastSaveTime) > saveDelay) {
                        $scope.saving = true;
                        $scope.lastSaveTime = currentTime;

                        $http.post(apiEditorInteractBackendUri, {'title': title, 'content': content, 'name': name}).
                        success(function(data, status, headers, config) {
                            $scope.saving = false;
                            $scope.callbackMsg = data.message;
                            $scope.article.name = data.name;
                        }).
                        error(function(data, status, headers, config) {
                            $scope.saving = false;
                            $scope.callbackMsg = data.message;
                        });
                    }
                }
            };

        }
    ]);

})();
