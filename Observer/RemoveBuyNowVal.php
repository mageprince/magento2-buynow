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

namespace Mageprince\BuyNow\Observer;

use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RemoveBuyNowVal implements ObserverInterface
{
    /**
     * @var CustomerCart
     */
    protected $cart;

    /**
     * @param CustomerCart $cart
     */
    public function __construct(
        CustomerCart $cart
    ) {
        $this->cart = $cart;
    }

    public function execute(Observer $observer)
    {
        if ($this->cart->getQuote()->getItemsCount() > 1) {
            $this->cart->getQuote()->setBuyNowId(0);
            $this->cart->getQuote()->save();
        }
    }
}
