<?php

namespace Kirill\Coins\Observer;

use Magento\Framework\Event\ObserverInterface;
use Kirill\Coins\Model\ResourceModel\Coins;
class ProOrder implements ObserverInterface
{
    /**
     * Order Model
     *
     * @var \Magento\Sales\Model\Order $order
     */
    protected $order;
    protected $coins;
    protected $model;
    public function __construct(
        \Magento\Sales\Model\Order $order,
        Coins $coins,
        Coins $model,
        \Kirill\Coins\Model\CoinsFactory $dataFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    )
    {
        $this->order = $order;
        $this->coins = $coins;
        $this->_dataFactory = $dataFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder()->getSubtotal();
        $customerId = $observer->getEvent()->getOrder()->getCustomerId();
        $orderId = $observer->getEvent()->getOrder()->getId();
        $bonuscoins = (int)$order/10;
        if ($customerId) {
            $savedata = $this->_dataFactory->create();
            $savedata ->addData(['coins'=>$bonuscoins,'order_id'=>$orderId,'customer_id'=>$customerId,'comment'=>'Earn Coins from Order'])->save();
            $customer = $this->_customerRepositoryInterface->getById($customerId);
            $customer->setCustomAttribute('coins', $bonuscoins);
            $this->_customerRepositoryInterface->save($customer);

        }
    }
}
