'use strict';

var io = {};
var notificationsGlobals = appGlobals || {};

notificationsGlobals = {
    app : {
        name : 'io.programmar'
    },
    controller: {
        name: 'NotificationsController'
    }
};

(function () {
    'use strict';
    io.programmar = io.programmar || {};
    io.programmar.core = angular.module(notificationsGlobals.app.name, [
    	'io.programmar.core',
    ]);
})();