<?php

namespace Kirill\Coins\Observer;

use Kirill\Coins\Api\Data\CoinsInterface;
use Kirill\Coins\Helper\Data;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Kirill\Coins\Model\CoinsRepository;
use \Magento\Framework\Event\Observer;

class SaveAndWasteCoinsFromOrder implements ObserverInterface
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
        Order              $order,
        CoinsRepository    $coinsRepository,
        CustomerRepository $customerRepository,
        Data               $helper
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
        $order = $observer->getOrder();
        $customer = $this->getCustomer($observer);
        $customerId = $customer->getId();
        $orderId = $order->getId();
        $subtotal = $this->getSubtotal($observer);
        $coins = $this->getCoinsForOrder($subtotal);
        $OldCustomerCoins = $this->getOldCustomerCoins($customer);
        if ($customerId && $quoteMethod != 'coins_payment_option') {
            $this->setCoins($coins, $orderId, $customerId,'Earn Coins From Order');
            $SaveCustomerCoins = $customer->setCustomAttribute('coins', $OldCustomerCoins + $coins);
            $this->customerRepository->save($SaveCustomerCoins);
        } else {
                $this->setCoins(-$subtotal,$orderId,$customerId,'Waste Coins From Order');
        }

    }

    /** Check method from configuration
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

    /**
     * @param $subtotal
     * @param $orderId
     * @param $customerId
     * @param string $comment
     * @return CoinsInterface
     * @throws CouldNotSaveException
     */
    public function setCoins($subtotal, $orderId, $customerId, string $comment)
    {
        $savedata = $this->coinsRepository->getNewInstance();
        $savedata->addData(['coins' => $subtotal, 'order_id' => $orderId, 'customer_id' => $customerId, 'comment' => $comment]);
        $this->coinsRepository->save($savedata);
    }

    /** Get Customer Coins
     * @param $customer
     * @return mixed
     */
    public function getOldCustomerCoins($customer)
    {
        return $customer->getCustomAttributes()['coins']->getValue();
    }

    /**
     * @param $order
     * @return int
     */
    public function getCoinsForOrder($subtotal)
    {
        $percent = $this->helper->getPercent();
        $percentfororder = 100 /($percent);
        $coins = (int)($subtotal / $percentfororder);
        return $coins;
    }
}
