'use strict';

var com = {};
var appGlobals = appGlobals || {};

appGlobals = {
    app : {
        name : 'com.programmar.core'
    },
    api : {
        rootRoute : '/api/v2'
    },
    controller: {
        name: 'ProgrammarCoreCtrl'
    }
};

(function () {
    'use strict';
    com.programmar = com.programmar || {};
    com.programmar.core = angular.module(appGlobals.app.name, ['ngResource'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });
})();