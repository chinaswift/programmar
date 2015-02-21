(function () {

    'use strict';

    var apiEndPoint = appGlobals.api.rootRoute + '/articles/:user_id';

    com.programmar.core.factory('ArticleApi', ['$resource', function ($resource) {

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
