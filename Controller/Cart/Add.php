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

namespace Mageprince\Buynow\Controller\Cart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Checkout\Model\Cart\RequestQuantityProcessor;
use Magento\Framework\App\ObjectManager;

class Add extends \Magento\Checkout\Controller\Cart\Add
{
    /**
     * @var \Mageants\GiftCard\Model\Account
     */
    protected $productRepository;

    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var RequestQuantityProcessor
     */
    private $quantityProcessor;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param CustomerCart $cart
     * @param ProductRepositoryInterface $productRepository
     * @param RequestQuantityProcessor $quantityProcessor
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        CustomerCart $cart,
        ProductRepositoryInterface $productRepository,
        ? RequestQuantityProcessor $quantityProcessor = null,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    ) {
        $this->productRepository = $productRepository;
        $this->quantityProcessor = $quantityProcessor ?? ObjectManager::getInstance()->get(RequestQuantityProcessor::class);
        $this->quoteRepository = $quoteRepository;
        $this->storeManager = $storeManager;
        $this->quoteFactory = $quoteFactory;
        $this->customerRepository = $customerRepository;
        $this->scopeConfig = $scopeConfig;
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart,
            $productRepository,
            $quantityProcessor
        );
    }

    /**
     * Add product to shopping cart action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $mainQuoteId = $this->cart->getQuote()->getEntityId();
        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $params = $this->getRequest()->getParams();
        try {
            if (isset($params['qty'])) {
                $filter = new \Zend_Filter_LocalizedToNormalized(
                    ['locale' => $this->_objectManager->get('Magento\Framework\Locale\ResolverInterface')->getLocale()]
                );
                $params['qty'] = $filter->filter($params['qty']);
            }
            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');
            if (!$product) {
                return $this->goBack();
            }
            $cartProducts = $this->scopeConfig->getValue(
                'buynow/general/keep_cart_products',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            if (!$cartProducts) {
                $cartRestore = $this->scopeConfig->getValue(
                    'buynow/general/restore_cart_products',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
                if ($cartRestore) {
                    if ($mainQuoteId) {
                        $quoteRepo = $this->quoteRepository->get($mainQuoteId);
                        $quoteRepo->setData('is_active', 0);
                        $this->quoteRepository->save($quoteRepo);
                    }
                    $store = $this->storeManager->getStore();
                    $websiteId = $this->storeManager->getStore()->getWebsiteId();
                    $quoteData = $this->quoteFactory->create();
                    $quoteData->setStore($store);
                    $quoteData->setCurrency();
                    if ($this->cart->getQuote()->getCustomerId()) {
                        $customerId = $this->cart->getQuote()->getCustomerId();
                        $customerEmail = $this->cart->getQuote()->getCustomerEmail();
                        $customerRepoData = $this->customerRepository->getById($customerId);
                        $quoteData->assignCustomer($customerRepoData);
                    }
                    if ($mainQuoteId) {
                        $quoteData->setBuyNowId($mainQuoteId);
                    }
                    $quoteData->save();
                    $this->cart->setQuote($quoteData);
                } else {
                    $this->cart->truncate(); //remove all products from cart
                }
            }
            $this->cart->addProduct($product, $params);
            if (!empty($related)) {
                $this->cart->addProductsByIds(explode(',', $related));
            }
            $this->cart->save();

            // $this->_eventManager->dispatch(
            //     'checkout_cart_add_product_complete',
            //     ['product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse()]
            // );

            if (!$this->_checkoutSession->getNoCartRedirect(true)) {
                $baseUrl = $this->_objectManager->get('\Magento\Store\Model\StoreManagerInterface')
                    ->getStore()->getBaseUrl();
                return $this->goBack($baseUrl . 'checkout/', $product);
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            if ($this->_checkoutSession->getUseNotice(true)) {
                $this->messageManager->addNotice(
                    $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($e->getMessage())
                );
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->messageManager->addError(
                        $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($message)
                    );
                }
            }
            $url = $this->_checkoutSession->getRedirectUrl(true);
            if (!$url) {
                $cartUrl = $this->_objectManager->get('Magento\Checkout\Helper\Cart')->getCartUrl();
                $url = $this->_redirect->getRedirectUrl($cartUrl);
            }
            return $this->goBack($url);
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            return $this->goBack();
        }
    }
}
