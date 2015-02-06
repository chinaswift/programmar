(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);
    var apiEditorInteractBackendUri = '/api/internal/v1/editor/save';

    var titleSelector = '.ng-title-area',
        contentSelector = '.ng-content-area';

    app.controller(editorGlobals.controller.name, [
        '$scope',
        '$http',
        '$window',
        function ($scope, $http, $window) {

            //Default variables
            $scope.saving = false;
            $scope.callbackMsg = false;
            $scope.lastSaveTime = false;
            var saveDelay = 1 * 60 * 1000; //1 minutes (ms)


            //Function for saving the document
            $scope.saveDocument = function() {
                var title = $scope.article.title,
                    content = $scope.article.content,
                    currentTime = new Date();

                //If first edit, or its been longer that 3mins.
                if(!$scope.lastSaveTime || (currentTime - $scope.lastSaveTime) > saveDelay) {
                    $scope.saving = true;
                    $scope.lastSaveTime = currentTime;

                    $http.post(apiEditorInteractBackendUri, {title: title, content: content}).
                        success(function(data, status, headers, config) {
                            $scope.saving = false;
                            $scope.callbackMsg = data.message;
                        }).
                        error(function(data, status, headers, config) {
                            $scope.saving = false;
                            $scope.callbackMsg = data.message;
                        });
                }
            };

        }
    ]);

})();
