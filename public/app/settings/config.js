'use strict';

var io = {};
var settingsGlobals = appGlobals || {};

settingsGlobals = {
    app : {
        name : 'io.programmar'
    },
    controller: {
        name: 'SettingsController'
    }
};

(function () {
    'use strict';
    io.programmar = io.programmar || {};
    io.programmar.core = angular.module(settingsGlobals.app.name, [
    	'io.programmar.core',
    ]);
})();