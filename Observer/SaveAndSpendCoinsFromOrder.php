<?php

namespace Kirill\Coins\Observer;

use Kirill\Coins\Api\Data\CoinsInterface;
use Kirill\Coins\Helper\Data;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Sales\Model\Order;
use Kirill\Coins\Model\CoinsRepository;
use \Magento\Framework\Event\Observer;

class SaveAndSpendCoinsFromOrder implements ObserverInterface
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

    /**
     * @param Order $order
     * @param CoinsRepository $coinsRepository
     * @param CustomerRepository $customerRepository
     * @param Data $helper
     */
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
        $paymentMethod = $observer->getOrder()->getPayment()->getMethod();
        $order = $observer->getOrder();
        $customer = $observer->getQuote()->getCustomer();
        $customerId = $order->getCustomerId();
        $orderId = $order->getId();
        $subtotal = $order->getSubTotal();
        $coins = $this->getCoinsForOrder($subtotal);
        if ($customerId && $paymentMethod != 'coins_payment_option') {
            $this->saveCoins($coins, $orderId, $customerId,'Earn Coins From Order');
            $this->updateCoins($customer,$coins);
        } else {
            $this->saveCoins(-$subtotal,$orderId,$customerId,'Waste Coins From Order');
        }

    }
    /** Save coins in database
     * @param $subtotal
     * @param $orderId
     * @param $customerId
     * @param string $comment
     * @return CoinsInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function saveCoins($subtotal, $orderId, $customerId, string $comment)
    {
        $saveCoins = $this->coinsRepository->getNewInstance();
        $saveCoins->addData(['coins' => $subtotal, 'order_id' => $orderId, 'customer_id' => $customerId, 'comment' => $comment]);
        return $this->coinsRepository->save($saveCoins);
    }
    /** Get Current Customer Coins
     * @param $customer
     * @return int
     */
    public function getCurrentCustomerCoins($customer): int
    {
        if ($customer->getCustomAttribute('coins')) {
            return $customer->getCustomAttribute('coins')->getValue();
        }
        return 0;
    }
    /** Get Coins for Order
     * @param $subtotal
     * @return int
     */
    public function getCoinsForOrder($subtotal): int
    {
        $percent = $this->helper->getPercent();
        $percentForOrder = 100 /($percent);
        return (int)($subtotal / $percentForOrder);
    }
    /** Save coins for customer
     * @param $customer
     * @param $subtotal
     * @return \Magento\Customer\Api\Data\CustomerInterface|void
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function updateCoins($customer,$subtotal)
    {
            $currentCustomerCoins = $this->getCurrentCustomerCoins($customer);
            $customer->setCustomAttribute('coins', $currentCustomerCoins + $subtotal);
            return $this->customerRepository->save($customer);
    }
}
