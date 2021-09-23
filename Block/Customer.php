<?php
namespace Kirill\Coins\Block;


class Customer extends \Magento\Framework\View\Element\Template
{
protected $customerSession;

/**
* Construct
*
* @param \Magento\Framework\View\Element\Template\Context $context
* @param \Magento\Customer\Model\Session $customerSession
* @param array $data
*/
public function __construct(
\Magento\Framework\View\Element\Template\Context $context,
\Magento\Customer\Model\Session $customerSession,
array $data = []
) {
parent::__construct($context, $data);

$this->customerSession = $customerSession;
}

public function getCustomer()
    {
        echo $this->customerSession->getCustomer()->getId(); //Print current customer ID

        $customerData = $this->customerSession->getCustomer();
        print_r($customerData->getData()); //Print current Customer Data
    }
}
