<?php

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
