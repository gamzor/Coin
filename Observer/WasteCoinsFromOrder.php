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
        $quoteMethod = $observer->getOrder()->getPayment()->getMethod();
        $Subtotal = $observer->getOrder()->getSubtotal();
        $customerId = $observer->getOrder()->getCustomerId();
        $orderId = $observer->getOrder()->getId();
        if ($customerId && $quoteMethod == 'coins_payment_option') {
            $savedata = $this->coinsRepository->getNewInstance();
            $savedata->addData(['coins' => -$Subtotal, 'order_id' => $orderId, 'customer_id' => $customerId, 'comment' => 'Waste Coins from Order']);
            $this->coinsRepository->save($savedata);
        }
    }
}
