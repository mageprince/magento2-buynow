define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {
        var addToCardForm = $(element).parent().parent().find('form');
        var buyNowBtn = $(element).html();
        addToCardForm.append(buyNowBtn);
        $(element).html('');
    }
});
