define([
    'jquery',
    'Mageprince_BuyNow/js/model/buy-now'
], function ($, buyNowModel) {
    'use strict';

    return function (config, element) {
        $(element).click(function () {
            $(this).attr('disabled', true);
            var form = $(element.form),
                baseUrl = form.attr('action'),
                buyNowUrl = buyNowModel.replaceBuyNowUrl(baseUrl);
            form.attr('action', buyNowUrl);
            form.trigger('submit');
            form.attr('action', baseUrl);
            return false;
        });
    }
});
