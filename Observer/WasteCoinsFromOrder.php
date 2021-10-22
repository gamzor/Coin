<?php

namespace Kirill\Coins\Observer;

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

    public function __construct(
        Order                        $order,
        CoinsRepository               $coinsRepository,
        CustomerRepository $customerRepository
    )
    {
        $this->order = $order;
        $this->coinsRepository = $coinsRepository;
        $this->customerRepository = $customerRepository;
    }

    /** Waste coins after order
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function execute(Observer $observer)
    {
        $quoteMethod = $this->coinsRepository->getMethod($observer);
        $subtotal = $this->coinsRepository->getSubtotal($observer);
        $customerId = $this->coinsRepository->getCustomer($observer)->getId();
        $orderId = $observer->getOrder()->getId();
        if ($customerId && $quoteMethod == 'coins_payment_option') {
            $this->coinsRepository->Savecoins(-$subtotal,$orderId,$customerId);
        }
    }

}
