<?php

namespace Kirill\Coins\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomerSaveAfterObserver implements ObserverInterface
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Kirill\Coins\Model\CoinsFactory
     */
    protected $_balanceFactory;

    /**
     * Constructor
     *
     * @param \Kirill\Coins\Model\CoinsFactory $balanceFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Kirill\Coins\Model\CoinsFactory $balanceFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_balanceFactory = $balanceFactory;
        $this->_storeManager = $storeManager;
    }

    /**
     * Customer balance update after save
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        /* @var $request \Magento\Framework\App\RequestInterface */
      $request = $observer->getRequest();
      $var = $request->getPost('coins');
        /* @var $customer \Magento\Customer\Api\Data\CustomerInterface */
            $balance = $this->_balanceFactory->create();
            $balance->addData(['coins'=>$var['amount_coins'],'comment'=>$var['comment']]);
            $balance->save();
    }
}
