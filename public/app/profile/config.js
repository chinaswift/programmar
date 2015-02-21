'use strict';

var profileGlobals = (appGlobals)? angular.copy(appGlobals) : {};

profileGlobals.app = {
    name : 'com.programmar'
};

profileGlobals.controller = {
    name : 'ProfileCtrl'
};

(function () {

    'use strict';

    angular.module(profileGlobals.app.name,
        [
            'com.programmar.core',
        ]
    );

})();


