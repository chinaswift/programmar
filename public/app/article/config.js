'use strict';

var io = {};
var articleGlobals = appGlobals || {};

articleGlobals = {
    app : {
        name : 'io.programmar'
    },
    controller: {
        name: 'ArticleController'
    }
};

(function () {
    'use strict';
    io.programmar = io.programmar || {};
    io.programmar.core = angular.module(articleGlobals.app.name, [
    	'io.programmar.core',
    ]);
})();