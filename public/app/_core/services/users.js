(function () {

    'use strict';


    io.programmar.core.factory('Users', function() {
        return algoliasearch('EBXLKPZAJZ', '09200ca98073ebd9ca2a418f62b32dd2').initIndex('users');
    });

})();
