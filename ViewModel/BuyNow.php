<?php

namespace Mageprince\BuyNow\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Mageprince\BuyNow\Helper\Data;

class BuyNow implements ArgumentInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * BuyNow constructor.
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Retrieve button title
     *
     * @return string
     */
    public function getButtonTitle()
    {
        return $this->helper->getButtonTitle();
    }

    /**
     * Retrieve form id
     *
     * @return string
     */
    public function getAddToCartFormId()
    {
        return $this->helper->getAddToCartFormId();
    }
}
