'use strict';

var io = {};
var feedGlobals = appGlobals || {};

feedGlobals = {
    app : {
        name : 'io.programmar'
    },
    controller: {
        name: 'FeedController'
    }
};

(function () {
    'use strict';
    io.programmar = io.programmar || {};
    io.programmar.core = angular.module(feedGlobals.app.name, [
    	'io.programmar.core',
    ]);
})();