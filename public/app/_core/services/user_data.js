(function () {

    'use strict';

    var apiEndPoint = '/user/collect/me';

    io.programmar.core.factory('UserData', ['$resource', function ($resource) {
        var paramDefaults = {};
        var actions = {
            query : {
                method : 'GET',
                isArray : false
            }
        };
        return $resource(apiEndPoint, paramDefaults, actions);
    }]);

})();
