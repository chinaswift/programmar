(function () {

    'use strict';

    com.programmar.core.factory('ProgrammarMessages', function () {

        var confirmSelector = '.confirm-message',
            confirmMessageSelector = confirmSelector + ' .message',
            confirmOptionOneSelector = confirmSelector + ' .option-one',
            confirmOptionTwoSelector = confirmSelector + ' .option-two';

        var confirmDialog = function(message, optionOne, optionTwo) {
            var $confirmDialog = $(confirmSelector),
                $confirmMessage = $(confirmMessageSelector),
                $confirmOptionOne = $(confirmOptionOneSelector),
                $confirmOptionTwo = $(confirmOptionTwoSelector);

            $confirmMessage.text(message);
            $confirmOptionOne.text(optionOne);
            $confirmOptionTwo.text(optionTwo);

            $confirmDialog.show();

            return false;
        };



        return {
            'confirm': confirmDialog,
        }

    });

})();
