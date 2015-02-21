'use strict';

var homeGlobals = (appGlobals)? angular.copy(appGlobals) : {};

homeGlobals.app = {
    name : 'com.programmar'
};

homeGlobals.controller = {
    name : 'HomeCtrl'
};

(function () {

    'use strict';

    angular.module(homeGlobals.app.name,
        [
            'com.programmar.core'
        ]
    );

})();


