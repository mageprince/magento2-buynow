<?php

/**
 * MagePrince
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageprince.com license that is
 * available through the world-wide-web at this URL:
 * https://mageprince.com/end-user-license-agreement
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    MagePrince
 * @package     Mageprince_BuyNow
 * @copyright   Copyright (c) MagePrince (https://mageprince.com/)
 * @license     https://mageprince.com/end-user-license-agreement
 */

namespace Mageprince\BuyNow\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Buynow config paths
     */
    public const BUYNOW_BUTTON_TITLE_PATH = 'buynow/general/button_title';
    public const ADDTOCART_FORM_ID_PATH = 'buynow/general/addtocart_id';
    public const ADDTOCART_FORM_ID = 'product_addtocart_form';
    public const KEEP_CART_PRODUCTS_PATH = 'buynow/general/keep_cart_products';

    /**
     * Retrieve config value
     *
     * @param string $config
     * @return mixed
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve button title
     *
     * @return string
     */
    public function getButtonTitle()
    {
        return $this->getConfig(self::BUYNOW_BUTTON_TITLE_PATH);
    }

    /**
     * Retrieve addtocart form id
     *
     * @return string
     */
    public function getAddToCartFormId()
    {
        $addToCartFormId = $this->getConfig(self::ADDTOCART_FORM_ID_PATH);
        return $addToCartFormId ?: self::ADDTOCART_FORM_ID;
    }

    /**
     * Check if keep cart products
     *
     * @return string
     */
    public function keepCartProducts()
    {
        return $this->getConfig(self::KEEP_CART_PRODUCTS_PATH);
    }
}
