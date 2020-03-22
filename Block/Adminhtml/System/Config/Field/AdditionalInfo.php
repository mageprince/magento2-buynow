<?php

/**
 * MagePrince
 * Copyright (C) 2020 Mageprince <info@mageprince.com>
 *
 * @package Mageprince_Extrafee
 * @copyright Copyright (c) 2020 Mageprince (http://www.mageprince.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MagePrince <info@mageprince.com>
 */

namespace Mageprince\BuyNow\Block\Adminhtml\System\Config\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;

class AdditionalInfo extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Returns element html
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $html= '<div class="userguide-container" style="border:dotted 1px #ccc; padding:20px;">
<div id="messages"><ul class="messages"><li class="message message-notice notice" style="list-style: none;"><ul>
<li style="list-style: none;">&#60;&#63;php echo &#36;this->getLayout()->createBlock("Mageprince\BuyNow\Block\Product\ListProduct")->setProduct(&#36;product)
->setTemplate("Mageprince_BuyNow::buynow-list.phtml")->toHtml(); &#63;&#62;</li></ul></li></ul>
</div><code>Use this code to add BuyNow button on any product listing.<br>
NOTE: You need to pass product object (@var $product \Magento\Catalog\Model\Product)</code></div>';

        return $html;
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '<td>'.$this->_getElementHtml($element).'</td>';
        return $this->_decorateRowHtml($element, $html);
    }
}
