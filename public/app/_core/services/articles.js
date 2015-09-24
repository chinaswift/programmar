(function () {

    'use strict';


    io.programmar.core.factory('Articles', function() {
        return algoliasearch('EBXLKPZAJZ', '09200ca98073ebd9ca2a418f62b32dd2').initIndex('articles');
    });

})();
