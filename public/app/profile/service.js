(function () {

    'use strict';

    var app = angular.module('Services', []).factory('githubService', function($http) {

    	var followUser = function(username) {
    		return $http({
    			method: 'GET',
    			type: 'application/json',
    			url: '/api/angular/github/follow/' + username
    		})
    	};

    	var unfollowUser = function(username) {
    		return $http({
    			method: 'GET',
    			type: 'application/json',
    			url: '/api/angular/github/unfollow/' + username
    		})
    	};

        return {
            follow: function(username) {
                return followUser(username);
            },

            unfollow: function(username) {
                return unfollowUser(username);
            }
        }
    });

})();
