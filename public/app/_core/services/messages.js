(function () {

    'use strict';

    com.programmar.core.factory('ProgrammarMessages', function () {

        var confirmSelector = '.confirm-message',
            confirmMessageSelector = confirmSelector + ' .message',
            confirmOptionOneSelector = confirmSelector + ' .option-one',
            confirmOptionTwoSelector = confirmSelector + ' .option-two';

        var confirmDialog = function(message, optionOne, optionTwo, type, callback) {
            var $confirmDialog = $(confirmSelector),
                $confirmMessage = $(confirmMessageSelector),
                $confirmOptionOne = $(confirmOptionOneSelector),
                $confirmOptionTwo = $(confirmOptionTwoSelector),
                option = '';

            $confirmMessage.text(message);
            $confirmOptionOne.text(optionOne);
            $confirmOptionTwo.text(optionTwo);

            $confirmDialog.addClass(type).show();

            $confirmOptionOne.on('click', function() {
                $confirmDialog.fadeOut();
                option = true;
                if (callback && typeof(callback) === "function") {
                    callback('cancel');
                }
            });

            $confirmOptionTwo.on('click', function() {
                $confirmDialog.fadeOut();
                option = false;
                if (callback && typeof(callback) === "function") {
                    callback('confirm');
                }
            });
        };



        return {
            'confirm': confirmDialog,
        }

    });

})();
