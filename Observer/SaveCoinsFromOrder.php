<?php

namespace Kirill\Coins\Observer;

use Kirill\Coins\Helper\Data;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Kirill\Coins\Model\CoinsRepository;
use \Magento\Framework\Event\Observer;
class SaveCoinsFromOrder implements ObserverInterface
{
    /**
     * Order Model
     *
     * @var Order $order
     */
    protected $order;
    /**
     * @var CoinsRepository
     */
    private CoinsRepository $coinsRepository;
    /**
     * @var Data
     */
    private Data $helper;

    public function __construct(
        Order                        $order,
        CoinsRepository               $coinsRepository,
        CustomerRepository $customerRepository,
        Data                         $helper
    )
    {
        $this->order = $order;
        $this->coinsRepository = $coinsRepository;
        $this->customerRepository = $customerRepository;
        $this->helper = $helper;
    }

    /** Save coins after order
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function execute(Observer $observer)
    {
        $quoteMethod = $this->getMethod($observer);
        $order = $this->getSubtotal($observer);
        $customer = $this->getCustomer($observer);
        $customerId = $customer->getId();
        $orderId = $observer->getOrder()->getId();
        $percent = 100 / ($this->helper->getPercent());
        $coins = (int)($order / $percent);
        if ($customerId && $quoteMethod != 'coins_payment_option') {
           $this->SaveCoins($coins,$orderId,$customerId);
           $this->SaveCoinsForCustomer($customer,$coins);
        }
    }

    /** Check method from configuration
     * @param $observer
     * @return mixed
     */
    public function getMethod($observer)
    {
        return $observer->getOrder()->getPayment()->getMethod();
    }

    /** Check subtotal order
     * @param $observer
     * @return mixed
     */
    public function getSubtotal($observer)
    {
       return $observer->getOrder()->getSubtotal();
    }

    /** Identify the current customer
     * @param $observer
     * @return mixed
     */
    public function getCustomer($observer)
    {
       return $observer->getQuote()->getCustomer();
    }

    /** Create row in table Coins
     * @param $coins
     * @param $orderId
     * @param $customerId
     * @return \Kirill\Coins\Api\Data\CoinsInterface|\Kirill\Coins\Model\Coins
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function SaveCoins($coins,$orderId,$customerId)
    {
        $savedata = $this->coinsRepository->getNewInstance();
        $savedata->addData(['coins' => $coins, 'order_id' => $orderId, 'customer_id' => $customerId, 'comment' => 'Earn Coins from Order']);
        return $this->coinsRepository->save($savedata);
    }

    /** Get Customer Coins
     * @param $customer
     * @return mixed
     */
    public function getOldCustomerCoins($customer)
    {
        return $customer->getCustomAttributes()['coins']->getValue();
    }

    public function SaveCoinsForCustomer($customer,$coins)
    {
        $oldcustomerCoins = $this->getOldCustomerCoins($customer);
        $savecustomerCoins = $customer->setCustomAttribute('coins',$oldcustomerCoins+$coins);
      return $this->customerRepository->save($savecustomerCoins);
    }

}
