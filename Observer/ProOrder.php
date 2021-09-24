<?php

namespace Kirill\Coins\Observer;

use Magento\Framework\Event\ObserverInterface;
use Kirill\Coins\Model\Coins;
class ProOrder implements ObserverInterface
{
    /**
     * Order Model
     *
     * @var \Magento\Sales\Model\Order $order
     */
    protected $order;
    protected $coins;
    /**
     * @var Coins
     */
    protected $coinsmodel;

    public function __construct(
        \Magento\Sales\Model\Order $order,
        \Kirill\Coins\Model\ResourceModel\Coins $coins,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        Coins $coinsmodel
    )
    {
        $this->order = $order;
        $this->coins = $coins;
        $this->resultPageFactory = $resultPageFactory;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->coin = $coinsmodel;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder()->getGrandTotal();
        $customerId = $observer->getEvent()->getOrder()->getCustomerId();
        $orderId = $observer->getEvent()->getOrder()->getId();
        $coins = $order/10;
        if ($customerId) {

            $customer = $this->_customerRepositoryInterface->getById($customerId);
            $customer->setCustomAttribute('coins', $coins);
            $this->_customerRepositoryInterface->save($customer);
            $coin = $coins;
            $this->coin->save();

        }
        print_r("Catched event succssfully !");
        exit;
    }
}
