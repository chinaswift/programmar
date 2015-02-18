'use strict';

var editorGlobals = (appGlobals)? angular.copy(appGlobals) : {};

editorGlobals.app = {
    name : 'com.programmar'
};

editorGlobals.controller = {
    name : 'ArticleCtrl'
};

(function () {

    'use strict';

    angular.module(editorGlobals.app.name,
        [
            'com.programmar.core'
        ]
    );

})();


