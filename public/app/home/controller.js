(function () {

    'use strict';

    var app = angular.module(homeGlobals.app.name);

    app.controller(homeGlobals.controller.name, [
        '$scope',
        '$http',
        '$location',
        '$window',
        function ($scope, $http, $location, $window) {

            $scope.pageLoaded = 0;
            $scope.loaderShow = false;

        }
    ]);
})();
