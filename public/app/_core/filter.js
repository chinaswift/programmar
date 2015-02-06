(function () {

    'use strict';

    /* Filters */
    com.programmar.core.filter('nl2br', function(){
        return function(text) {
            return text.replace(/\n/g, '<br>');
        };
    });

    com.programmar.core.filter('slice', function() {
        return function(arr, start, end) {
            return (arr || []).slice(start, end);
        };
    });

})();
