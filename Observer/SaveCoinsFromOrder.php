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
        $quoteMethod = $this->coinsRepository->getMethod($observer);
        $order = $this->coinsRepository->getSubtotal($observer);
        $customer = $this->coinsRepository->getCustomer($observer);
        $customerId = $customer->getId();
        $orderId = $observer->getOrder()->getId();
        $percent = 100 / ($this->helper->getPercent());
        $coins = (int)($order / $percent);
        if ($customerId && $quoteMethod != 'coins_payment_option') {
           $this->coinsRepository->Savecoins($coins,$orderId,$customerId);
            $oldcustomerCoins = $this->coinsRepository->getOldcustomercoins($customer);
            $savecustomerCoins = $customer->setCustomAttribute('coins',$oldcustomerCoins+$coins);
            $this->customerRepository->save($savecustomerCoins);
        }
    }
}
