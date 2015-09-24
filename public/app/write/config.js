'use strict';

var io = {};
var writeGlobals = appGlobals || {};

writeGlobals = {
    app : {
        name : 'io.programmar'
    },
    controller: {
        name: 'WriteController'
    }
};

(function () {
    'use strict';
    io.programmar = io.programmar || {};
    io.programmar.core = angular.module(writeGlobals.app.name, [
    	'io.programmar.core',
    ]);
})();