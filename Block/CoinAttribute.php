<?php

namespace Kirill\Coins\Block;

use Kirill\Coins\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session as CustomerSession;

class CoinAttribute extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;

    public function __construct(
        Template\Context $context,
        Registry         $registry,
        CustomerSession $customerSession,
        Data             $helper,
        array            $data)
    {
        $this->registry = $registry;
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     * @throws LocalizedException
     */
    public function getProduct(): Product
    {
        if ($this->product === null) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    /** Price for different types of product
     * @throws LocalizedException
     */
    public function getPrice(): int
    {
        return $this->getProduct()->getPriceInfo()->getPrice('final_price')->getValue();
    }

    /** Check if configuration is active
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helper->isEnabled();
    }

    /** Receive percent from configuration
     * @return int
     */
    public function getPercent()
    {
        return $this->helper->getPercent();
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomerId()
    {
        return $this->customerSession->getCustomer()->getId();
    }
}
