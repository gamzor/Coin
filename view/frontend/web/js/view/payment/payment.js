define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'coins_payment_option',
                component: 'Kirill_Coins/js/view/payment/method-renderer/payment-method'
            }
        );

        return Component.extend({});
    }
)
