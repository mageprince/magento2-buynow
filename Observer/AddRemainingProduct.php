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

class AddRemainingProduct implements ObserverInterface
{
    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var \Mageprince\BuyNow\Helper\Data
     */
    protected $buyNowHelper;

    /**
     * @var CustomerCart
     */
    protected $cart;

    /**
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Mageprince\BuyNow\Helper\Data $buyNowHelper
     * @param CustomerCart $cart
     */
    public function __construct(
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Mageprince\BuyNow\Helper\Data $buyNowHelper,
        CustomerCart $cart
    ) {
        $this->quoteFactory = $quoteFactory;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->buyNowHelper = $buyNowHelper;
        $this->cart = $cart;
    }

    public function execute(Observer $observer)
    {
        $flage = 1;
        $keepCartProduct = $this->buyNowHelper->keepCartProducts();
        $updateBuyNowCart = $restoreCartProduct = $this->buyNowHelper->restoreCartProducts();
        if (($keepCartProduct == 0) && ($restoreCartProduct == 1)) {
            try {
                $orderIds = $observer->getEvent()->getOrderIds();
                foreach ($orderIds as $orderIdsKey => $orderIdsVal) {
                    $orderData = $this->orderRepository->get($orderIdsVal);
                    $quoteData = $this->quoteFactory->create();
                    $quoteData->load($orderData->getQuoteId());
                    if ($quoteData->hasData()) {
                        if (($quoteData->getBuyNowId()) && ($quoteData->getCustomerId())) {
                            $customerRepoData = $this->customerRepository->getById($quoteData->getCustomerId());
                            $quoteDataReplace = $this->quoteFactory->create();
                            $quoteDataReplace->load($quoteData->getBuyNowId());
                            if ($quoteDataReplace->hasData()) {
                                $quoteDataReplace->assignCustomer($customerRepoData);
                                $quoteDataReplace->setBuyNowId(0);
                                $quoteDataReplace->setIsActive(1);
                                $quoteDataReplace->save();
                                if ($updateBuyNowCart) {
                                    $quoteData->setBuyNowId(0);
                                    $quoteDataReplace->setIsActive(0);
                                    $quoteData->save();
                                }
                            }
                        }
                    }
                    break;
                }
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $flage = 0;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $flage = 0;
            } catch (\Exception $e) {
                $flage = 0;
            }
        }
    }
}
