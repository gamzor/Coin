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
        \Kirill\Coins\Model\CoinsRepository $coinsRepository
    ) {
        $this->coinsRepository = $coinsRepository;
    }

    public function execute(Observer $observer)
    {

        /* @var $request \Magento\Framework\App\RequestInterface */
      $request = $observer->getRequest();
      $var = $request->getPost('coins');
        $balance = $this->coinsRepository->getNewInstance();
            $balance->addData(['coins'=>$var['amount_coins'],'comment'=>$var['comment']]);
            $this->coinsRepository->save($balance);
    }
}
