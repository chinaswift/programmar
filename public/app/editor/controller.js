(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);
    var apiEditorInteractBackendUri = '/api/internal/v1/editor/save';

    app.controller(editorGlobals.controller.name, [
        '$scope',
        '$http',
        '$location',
        '$window',
        function ($scope, $http, $location, $window) {

            //Default variables
            $scope.saving = false;
            $scope.callbackMsg = false;
            $scope.lastSaveTime = false;
            var saveDelay = 30 * 1000; //5 seconds (ms)

            //Apply initialised variables
            setTimeout(function() {
                $scope.$apply();
            }, 300);

            //Auto saving
            setTimeout(function() {
                scope.saveDocument();
            } 1000);


            //Function for saving the document
            $scope.saveDocument = function() {
                var title = $scope.article.title,
                    content = $scope.article.content,
                    name = $scope.article.name,
                    currentTime = new Date();

                //If first edit, or its been longer that 3mins.
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
            };

        }
    ]);

})();
