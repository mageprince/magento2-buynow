define([
    'jquery',
    'Mageprince_BuyNow/js/model/buy-now'
], function ($, buyNowModel) {
    'use strict';

    return function (catalogAddToCartWidget) {

        $.widget('mage.catalogAddToCart', catalogAddToCartWidget, {
            /** @inheritdoc */
            _create: function () {
                this._super();
                buyNowModel.initListBuyNowBtnSelector();
            },

            /**
             * @param {String} form
             */
            disableAddToCartButton: function (form) {
                if (this.isBuyNowRequest(form)) {
                    return false;
                }
                this._super(form);
            },

            /**
             * @param {String} form
             */
            enableAddToCartButton: function (form) {
                if (this.isBuyNowRequest(form)) {
                    return false;
                }
                this._super(form);
            },

            /**
             * @param {String} form
             * @returns {boolean}
             */
            isBuyNowRequest: function (form) {
                var isBuyNow = false,
                    formAction = form.attr('action');
                if (formAction.includes("buynow")) {
                    isBuyNow = true;
                }
                return isBuyNow;
            }
        });
    }
});
