define([
    'jquery'
], function ($) {
    "use strict";
    return function (config, element) {
        $(element).click(function () {
            var form = $(config.form),
                baseUrl = form.attr('action'),
                addToCartUrl = 'checkout/cart/add',
                buyNowCartUrl = 'buynow/cart/add',
                buyNowUrl = baseUrl.replace(addToCartUrl, buyNowCartUrl);
            form.attr('action', buyNowUrl);
            if(form.valid()) {
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function (data) {
                        form.attr('action', baseUrl);
                        if (data.hasOwnProperty('backUrl')) {
                            window.location.href = data.backUrl;
                        } else {
                            window.location.reload(true);
                        }
                    }
                });
            }
            return false;
        });
    }
});
