<?php

namespace Mageprince\BuyNow\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

class BuyNow implements ArgumentInterface
{
    /**
     * Buynow config paths
     */
    public const BUYNOW_BUTTON_TITLE_PATH = 'buynow/general/button_title';
    public const KEEP_CART_PRODUCTS_PATH = 'buynow/general/keep_cart_products';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * BuyNow constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve button title
     *
     * @return string
     */
    public function getButtonTitle()
    {
        return $this->scopeConfig->getValue(
            self::BUYNOW_BUTTON_TITLE_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if keep cart products
     *
     * @return string
     */
    public function keepCartProducts()
    {
        return $this->scopeConfig->isSetFlag(
            self::KEEP_CART_PRODUCTS_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }
}
