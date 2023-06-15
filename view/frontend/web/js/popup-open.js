define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    return function (config) {
        var modaloption = {
            type: 'popup',
            modalClass: 'modal-popup',
            responsive: true,
            innerScroll: true,
            clickableOverlay: true,
            title: 'Simple Modal'
        };

        var popup = modal(modaloption, $('.popup_general'));

        $('.popup_general_open-btn').on('click', function () {
            $('.popup_general').modal('openModal');
            $('.popup_general').empty();
            $('.popup_general').append(config.cmsBlock);
        });
    };
});
