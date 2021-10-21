<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Kirill\Coins\Model;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Payment\Model\InfoInterface;
use Magento\Payment\Model\Method\Logger;
use Magento\Quote\Model\Quote;

class Payment extends \Magento\Payment\Model\Method\AbstractMethod
{
    const CODE = 'coins_payment_option';

    protected $_canAuthorize = true;

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::CODE;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Helper\Data $paymentData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, Logger $logger, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, Session $customersession, \Magento\Quote\Api\Data\CartInterface $quote, CustomerRepository $customerRepository, array $data = [], DirectoryHelper $directory = null)
    {
        $this->customerSession = $customersession;
        $this->quote = $quote;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger, $resource, $resourceCollection, $data, $directory);
    }

    public function authorize(InfoInterface $payment, $amount): bool
    {
        $customer = $this->customerRepository->getById($this->customerSession->getId());
        if (!$customer) {
            $subtotal = $payment->getOrder()->getSubtotal();
            $oldcustomercoins = $customer->getCustomAttribute('coins')->getValue();
            $newcustomercoins = $customer->setCustomAttribute('coins', $oldcustomercoins - $subtotal);
            $this->customerRepository->save($newcustomercoins);
            return true;
        }
        return false;
    }

    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null): bool
    {
        if (!$quote) {
            return parent::isAvailable($quote);
        }
        if ($coins = $quote->getCustomer()->getCustomAttribute('coins')) {
            return (int)$coins->getValue() >= $quote->getSubtotal();
        }
        return false;
    }
}
