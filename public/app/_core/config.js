'use strict';

var io = {};
var appGlobals = appGlobals || {};

appGlobals = {
    app : {
        name : 'io.programmar.core'
    },
    controller: {
        name: 'ProgrammarController'
    }
};

(function () {
    'use strict';
    io.programmar = io.programmar || {};
    io.programmar.core = angular.module(appGlobals.app.name, ['ngResource']);
})();