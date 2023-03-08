'use strict';

(function () {

    Office.onReady(function () {
        // Office is ready
        $(document).ready(function () {
            // The document is ready
            // Use this to check whether the API is supported in the Word client.
            if (Office.context.requirements.isSetSupported('WordApi', '1.1')) {
                $('#supportedVersion').html('Support Word 2016 atau diatasnya.');
            }
            else {
                // Just letting you know that this code will not work with your version of Word.
                $('#supportedVersion').html('Support Word 2016 atau diatasnya.');
            }
        });
    });
})();