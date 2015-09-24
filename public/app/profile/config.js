'use strict';

var io = {};
var profileGlobals = appGlobals || {};

profileGlobals = {
    app : {
        name : 'io.programmar'
    },
    controller: {
        name: 'ProfileController'
    }
};

(function () {
    'use strict';
    io.programmar = io.programmar || {};
    io.programmar.core = angular.module(profileGlobals.app.name, [
    	'io.programmar.core',
    ]);
})();