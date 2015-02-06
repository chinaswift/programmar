(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);
    var apiJobPostInteractBackendUri = '/api/internal/v1/editor/interact';

    app.controller(editorGlobals.controller.name, [
        '$scope',
        '$http',
        '$window',
        function ($scope, $http, $window) {

            $scope.value = 'test';

        }
    ]);

})();
