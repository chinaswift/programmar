(function () {

    'use strict';

    var apiEndPoint = appGlobals.api.rootRoute + '/user/:userId.json';

    hr.snap.core.factory('UserApi', ['$resource', function ($resource) {

        var paramDefaults = {
            userId : 'me'
        };
        var actions = {
            query : {
                method : 'GET',
                params : {},
                isArray : false
            }
        };

        return $resource(apiEndPoint, paramDefaults, actions);
    }]);

})();
