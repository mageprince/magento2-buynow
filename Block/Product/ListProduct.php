<?php

/**
 * MagePrince
 * Copyright (C) 2018 Mageprince
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category MagePrince
 * @package Prince_Buynow
 * @copyright Copyright (c) 2018 MagePrince
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MagePrince
 */

namespace Prince\Buynow\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    /**
     * @var Prince\Buynow\Helper\Data
     */
    private $helper;

    /**
     * @param Magento\Catalog\Block\Product\Context $context
     * @param Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Magento\Framework\Url\Helper\Data $urlHelper
     * @param Prince\Buynow\Helper\Data $helper
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Prince\Buynow\Helper\Data $helper
    ) {
        $this->helper = $helper;
        parent::__construct(
            $context,
            $postDataHelper,
            $layerResolver,
            $categoryRepository,
            $urlHelper
        );
    }

    public function getProductDetailsHtml(\Magento\Catalog\Model\Product $product)
    {
        $enableList = $this->helper->getConfig('buynow/general/enableonlist');
        $html = '';
        if($enableList) {
            $html = $this->getLayout()
                 ->createBlock('Prince\Buynow\Block\Product\ListProduct')
                 ->setProduct($product)
                 ->setTemplate('Prince_Buynow::buynow-list.phtml')
                 ->toHtml();    
        }
        $renderer = $this->getDetailsRenderer($product->getTypeId());
        if ($renderer) {
            $renderer->setProduct($product);
            return $html.$renderer->toHtml();
        }
        return '';
    }
}
