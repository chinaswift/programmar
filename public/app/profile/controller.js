(function () {

    'use strict';

    var app = angular.module(profileGlobals.app.name);

    app.controller(profileGlobals.controller.name, [
        '$scope',
        '$http',
        '$location',
        '$window',
        'githubService',
        function ($scope, $http, $location, $window, githubService) {

            $scope.following = false;

            $scope.followUser = function(username) {
                githubService.follow(username).success(function(data, status) {
                    console.log('success');
                    $scope.following = true;
                }).error(function(data, status) {
                    console.log('error');
                    $scope.following = false;
                });
            };

            $scope.unfollowUser = function(username) {
                githubService.unfollow(username).success(function(data, status) {
                    console.log('success');
                    $scope.following = false;
                }).error(function(data, status) {
                    console.log('error');
                    $scope.following = true;
                });
            };


        }
    ]);

})();
