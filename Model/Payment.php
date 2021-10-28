<?php

namespace Kirill\Coins\Model;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Payment\Helper\Data;
use Magento\Payment\Model\InfoInterface;
use Magento\Payment\Model\Method\Logger;
use Magento\Quote\Api\Data\CartInterface;
use \Magento\Payment\Model\Method\AbstractMethod;
class Payment extends AbstractMethod
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

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\Payment\Helper\Data $paymentData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param Logger $logger
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param Session $customersession
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @param CustomerRepository $customerRepository
     * @param array $data
     * @param DirectoryHelper|null $directory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        Data $paymentData,
        ScopeConfigInterface $scopeConfig,
        Logger $logger,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        Session $customersession,
        CartInterface $quote,
        CustomerRepository $customerRepository,
        array $data = [],
        DirectoryHelper $directory = null)
    {
        $this->customerSession = $customersession;
        $this->quote = $quote;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger, $resource, $resourceCollection, $data, $directory);
    }

    /**
     * @param InfoInterface $payment
     * @param float $amount
     * @return bool
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function authorize(InfoInterface $payment, $amount): bool
    {
        $customer = $this->customerRepository->getById($this->customerSession->getId());
        if ($customer->getId()) {
            $subtotal = $payment->getOrder()->getSubtotal();
            $currentCustomerCoins = $customer->getCustomAttribute('coins')->getValue();
            $newCustomerCoins = $customer->setCustomAttribute('coins', $currentCustomerCoins - $subtotal);
            $this->customerRepository->save($newCustomerCoins);
            return true;
        }
        return false;
    }

    /** Check if customer have enough coins
     * @param \Magento\Quote\Api\Data\CartInterface|null $quote
     * @return bool
     */
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
