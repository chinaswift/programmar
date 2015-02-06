(function () {

    'use strict';

    var apiEndPoint = appGlobals.api.rootRoute + '/article/:articleId';

    com.programmar.core.factory('ArticleApi', ['$resource','$location', function ($resource, $location) {

        var paramDefaults = {
            articleId : '1423230291'
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
