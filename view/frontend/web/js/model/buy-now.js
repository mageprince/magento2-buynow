define([
    'jquery'
], function ($) {
    'use strict';

    return {
        addToCartUrl: 'checkout/cart/add',
        buyNowCartUrl: 'buynow/cart/add',
        buyNowBtnListSelector: '.mageprince-buynow-btn-list',
        isListBtnInitialized: false,

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
         *
         * Delegated and bound once, so it works whether it runs before or
         * after buy-now-list.js moves the buttons into the add to cart forms.
         */
        initListBuyNowBtnSelector: function () {
            var self = this;
            if (this.isListBtnInitialized) {
                return;
            }
            this.isListBtnInitialized = true;
            $(document).on('click', this.buyNowBtnListSelector, function (e) {
                var form = $(this).closest('form'),
                    baseUrl,
                    buyNowUrl;
                e.preventDefault();
                if (!form.length) {
                    return false;
                }
                $(this).attr('disabled', true);
                baseUrl = form.attr('action');
                buyNowUrl = self.replaceBuyNowUrl(baseUrl);
                form.attr('action', buyNowUrl);
                form.trigger('submit');
                form.attr('action', baseUrl);
                return false;
            });
        }
    }
});
