<?php

/**
 * MagePrince
 * Copyright (C) 2020 Mageprince <info@mageprince.com>
 *
 * @package Mageprince_BuyNow
 * @copyright Copyright (c) 2020 Mageprince (http://www.mageprince.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MagePrince <info@mageprince.com>
 */

namespace Mageprince\BuyNow\Controller\Onepage;

/**
 * Onepage checkout success controller class
 */
class Success extends \Magento\Checkout\Controller\Onepage\Success
{
    /**
     * Order success action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $session = $this->getOnepage()->getCheckout();
        if (!$this->_objectManager->get(\Magento\Checkout\Model\Session\SuccessValidator::class)->isValid()) {
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
        $session->clearQuote();
        //@todo: Refactor it to match CQRS
        $resultPage = $this->resultPageFactory->create();
        $this->_eventManager->dispatch(
            'checkout_onepage_controller_success_action',
            [
                'order_ids' => [$session->getLastOrderId()],
                'order' => $session->getLastRealOrder(),
            ]
        );

        /* Restore Product into Cart */
        $this->_eventManager->dispatch(
            'checkout_product_merge_custom',
            [
                'order' => $session->getLastRealOrder(),
                'update_data' => 0,
            ]
        );

        $this->_eventManager->dispatch(
            'checkout_product_merge_custom',
            [
                'order' => $session->getLastRealOrder(),
                'update_data' => 1,
            ]
        );

        return $resultPage;
    }
}
