<?php

namespace Kirill\Coins\Observer;

use Magento\Framework\Event\ObserverInterface;
use Kirill\Coins\Model\CoinsRepository;
use Magento\Framework\Event\Observer;
class CustomerSaveAfterObserver implements ObserverInterface
{

    /**
     * @var CoinsRepository
     */
    protected $coinsRepository;

    /**
     * Constructor
     *
     * @param \Kirill\Coins\Model\CoinsRepository $coinsRepository
     */
    public function __construct(
        CoinsRepository $coinsRepository
    ) {
        $this->coinsRepository = $coinsRepository;
    }

    /** Save coins and change coins from form
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function execute(Observer $observer)
    {

        /* @var $request \Magento\Framework\App\RequestInterface */
      $request = $observer->getRequest();
      $coins = $request->getPost('coins');
        $balance = $this->coinsRepository->getNewInstance();
            $balance->addData(['coins'=>$coins['amount_coins'],'comment'=>$coins['comment']]);
            $this->coinsRepository->save($balance);
    }
}
