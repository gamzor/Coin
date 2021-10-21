<?php

namespace Kirill\Coins\Observer;

use Kirill\Coins\Helper\Data;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Kirill\Coins\Model\CoinsRepository;
use \Magento\Framework\Event\Observer;
class WasteCoinsFromOrder implements ObserverInterface
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

    /** Waste coins after order
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function execute(Observer $observer)
    {
        $quoteMethod = $this->getMethod($observer);
        $subtotal = $this->getSubtotal($observer);
        $customerId = $this->getCustomer($observer)->getId();
        $orderId = $observer->getOrder()->getId();
        if ($customerId && $quoteMethod == 'coins_payment_option') {
            $this->SaveCoins($subtotal,$orderId,$customerId);
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
    public function SaveCoins($subtotal,$orderId,$customerId)
    {
        $savedata = $this->coinsRepository->getNewInstance();
        $savedata->addData(['coins' => -$subtotal, 'order_id' => $orderId, 'customer_id' => $customerId, 'comment' => 'Earn Coins from Order']);
        return $this->coinsRepository->save($savedata);
    }
}
