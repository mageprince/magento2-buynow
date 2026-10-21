define([
    'jquery',
    'Mageprince_BuyNow/js/model/buy-now'
], function ($, buyNowModel) {
    'use strict';

    return function (config, element) {
        var addToCardForm = $(element).parent().parent().find('form');
        addToCardForm.addClass('mageprince-buynow-list-form').append($(element).children());
        buyNowModel.initListBuyNowBtnSelector();
    }
});
