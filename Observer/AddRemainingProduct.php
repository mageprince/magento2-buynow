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

class AddRemainingProduct implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param CustomerCart $cart
     */
    public function __construct(
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        CustomerCart $cart
    ) {
        $this->quoteFactory = $quoteFactory;
        $this->customerRepository = $customerRepository;
        $this->cart = $cart;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $flage = 1;
        try {
            $order = $observer->getEvent()->getOrder();
            $quoteData = $this->quoteFactory->create();
            $quoteData->load($order->getQuoteId());
            if ($quoteData->hasData()) {
                if ($quoteData->getBuyNowId()) {
                    if ($quoteData->getCustomerId()) {
                        $customerRepoData = $this->customerRepository->getById($quoteData->getCustomerId());
                        $quoteDataReplace = $this->quoteFactory->create();
                        $quoteDataReplace->load($quoteData->getBuyNowId());
                        if ($quoteDataReplace->hasData()) {

                            $quoteDataReplace->assignCustomer($customerRepoData);
                            $quoteDataReplace->setBuyNowId(0);
                            $quoteDataReplace->setIsActive(1);
                            $quoteDataReplace->save();

                            /* Update buynow cart Value */
                            if ($observer->getEvent()->getUpdateData()) {
                                $quoteData->setBuyNowId(0);
                                $quoteDataReplace->setIsActive(0);
                                $quoteData->save();
                            }

                        }
                    }
                }
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
