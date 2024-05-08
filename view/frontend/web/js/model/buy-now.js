define([
    'jquery'
], function ($) {
    'use strict';

    return {
        addToCartUrl: 'checkout/cart/add',
        buyNowCartUrl: 'buynow/cart/add',
        buyNowBtnListSelector: '.mageprince-buynow-btn-list',

        /**
         * Replace add to cart url
         *
         * @param {string} baseUrl
         * @returns {String}
         */
        replaceBuyNowUrl: function (baseUrl) {
            return baseUrl.replace(this.addToCartUrl, this.buyNowCartUrl);
        },

        /**
         * Init buy now button click event for list page
         */
        initListBuyNowBtnSelector: function (e) {
            var self = this;
            $(this.buyNowBtnListSelector).click(function (e) {
                e.stopImmediatePropagation();
                e.preventDefault();
                $(this).attr('disabled', true);
                var form = $(this).closest('form'),
                    baseUrl = form.attr('action'),
                    buyNowUrl = self.replaceBuyNowUrl(baseUrl);
                form.attr('action', buyNowUrl);
                form.trigger('submit');
                form.attr('action', baseUrl);
                return false;
            });
        }
    }
});
