(function () {

    'use strict';

    var apiEndPoint = appGlobals.api.rootRoute + '/user/:slug';

    com.programmar.core.factory('UserApi', ['$resource', function ($resource) {

        var paramDefaults = {

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
