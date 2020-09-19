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

namespace Mageprince\BuyNow\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Buynow button title path
     */
    const BUYNOW_BUTTON_TITLE_PATH = 'buynow/general/button_title';

    /**
     * Buynow button title
     */
    const BUYNOW_BUTTON_TITLE = 'Buy Now';

    /**
     * Addtocart button form id path
     */
    const ADDTOCART_FORM_ID_PATH = 'buynow/general/addtocart_id';

    /**
     * Addtocart button form id
     */
    const ADDTOCART_FORM_ID = 'product_addtocart_form';

    /**
     * Keep cart products path
     */
    const KEEP_CART_PRODUCTS_PATH = 'buynow/general/keep_cart_products';

    /**
     * Retrieve config value
     *
     * @return string
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get button title
     * @return string
     */
    public function getButtonTitle()
    {
        $btnTitle = $this->getConfig(self::BUYNOW_BUTTON_TITLE_PATH);
        return $btnTitle ? $btnTitle : self::BUYNOW_BUTTON_TITLE;
    }

    /**
     * Get addtocart form id
     * @return string
     */
    public function getAddToCartFormId()
    {
        $addToCartFormId = $this->getConfig(self::ADDTOCART_FORM_ID_PATH);
        return $addToCartFormId ? $addToCartFormId : self::ADDTOCART_FORM_ID;
    }

    /**
     * Check if keep cart products
     * @return string
     */
    public function keepCartProducts()
    {
        return $this->getConfig(self::KEEP_CART_PRODUCTS_PATH);
    }
}
