<?php

namespace Kirill\Coins\Observer;

use Magento\Framework\Event\ObserverInterface;
class SaveCoins implements ObserverInterface
{
    /**
     * Order Model
     *
     * @var \Magento\Sales\Model\Order $order
     */
    protected $order;

    public function __construct(
        \Magento\Sales\Model\Order $order,
        \Kirill\Coins\Model\CoinsFactory $dataFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->order = $order;
        $this->_dataFactory = $dataFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder()->getSubtotal();
        $customerId = $observer->getEvent()->getOrder()->getCustomerId();
        $orderId = $observer->getEvent()->getOrder()->getId();
        $percent = $this->getConfig('coins/general/percent');
        $bonuscoins = (int)($order/$percent);
        if ($customerId) {
            $savedata = $this->_dataFactory->create();
            $savedata ->addData(['coins'=>$bonuscoins,'order_id'=>$orderId,'customer_id'=>$customerId,'comment'=>'Earn Coins from Order'])->save();
            $customer = $this->_customerRepositoryInterface->getById($customerId);
            $customer->setCustomAttribute('coins', $bonuscoins);
            $this->_customerRepositoryInterface->save($customer);

        }
    }
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
