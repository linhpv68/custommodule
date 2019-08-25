require([
        "jquery",
        "jquery/ui",
        'Magento_Ui/js/form/element/abstract',
        'mage/url',
        "!domReady"
    ], function ($, Abstract, url) {
        'use strict';
        console.log("custom.js");
        let src = $('.logo-img').attr('src');
        console.log(src);

    }
);
