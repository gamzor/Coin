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
<<<<<<< HEAD
        CoinsRepository $coinsRepository
=======
        \Kirill\Coins\Model\CoinsRepository $coinsRepository
>>>>>>> master
    ) {
        $this->coinsRepository = $coinsRepository;
    }

<<<<<<< HEAD
    /** Save coins and change coins from form
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
=======
>>>>>>> master
    public function execute(Observer $observer)
    {

        /* @var $request \Magento\Framework\App\RequestInterface */
      $request = $observer->getRequest();
<<<<<<< HEAD
      $coins = $request->getPost('coins');
        $balance = $this->coinsRepository->getNewInstance();
            $balance->addData(['coins'=>$coins['amount_coins'],'comment'=>$coins['comment']]);
=======
      $var = $request->getPost('coins');
        $balance = $this->coinsRepository->getNewInstance();
            $balance->addData(['coins'=>$var['amount_coins'],'comment'=>$var['comment']]);
>>>>>>> master
            $this->coinsRepository->save($balance);
    }
}
