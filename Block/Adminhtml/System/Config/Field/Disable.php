<?php

/**
 * MagePrince
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License that is bundled with this
 * package in the file LICENSE.
 *
 * @category    MagePrince
 * @package     Mageprince_BuyNow
 * @copyright   Copyright (c) MagePrince (https://mageprince.com/)
 * @license     https://opensource.org/licenses/MIT MIT License
 */

namespace Mageprince\BuyNow\Block\Adminhtml\System\Config\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Disable extends Field
{
    /**
     * Disable element
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setDisabled('disabled');
        return $element->getElementHtml();
    }
}
