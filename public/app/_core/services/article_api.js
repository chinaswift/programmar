(function () {

    'use strict';

    var apiEndPoint = appGlobals.api.rootRoute + '/article/:articleId';

    com.programmar.core.factory('ArticleApi', ['$resource','$location', function ($resource, $location) {

        var articleCode = $location.absUrl();
        articleCode = articleCode.substr(articleCode.lastIndexOf('/') + 1);

        var paramDefaults = {
            articleId : articleCode
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
