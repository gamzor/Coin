<?php

namespace Kirill\Coins\Observer;

use Kirill\Coins\Helper\Data;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Kirill\Coins\Model\CoinsRepository;
use \Magento\Framework\Event\Observer;
class SaveCoins implements ObserverInterface
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
        Data                         $helper
    )
    {
        $this->order = $order;
        $this->coinsRepository = $coinsRepository;
        $this->helper = $helper;
    }

<<<<<<< HEAD
    /** Save coins after order
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
=======
>>>>>>> master
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder()->getSubtotal();
        $customerId = $observer->getEvent()->getOrder()->getCustomerId();
        $orderId = $observer->getEvent()->getOrder()->getId();
        $percent = 100 / ($this->helper->getPercent());
<<<<<<< HEAD
        $coins = (int)($order / $percent);
        if ($customerId) {
            $savedata = $this->coinsRepository->getNewInstance();
            $savedata->addData(['coins' => $coins, 'order_id' => $orderId, 'customer_id' => $customerId, 'comment' => 'Earn Coins from Order']);
=======
        $bonuscoins = (int)($order / $percent);
        if ($customerId) {
            $savedata = $this->coinsRepository->getNewInstance();
            $savedata->addData(['coins' => $bonuscoins, 'order_id' => $orderId, 'customer_id' => $customerId, 'comment' => 'Earn Coins from Order']);
>>>>>>> master
            $this->coinsRepository->save($savedata);
        }
    }
}
