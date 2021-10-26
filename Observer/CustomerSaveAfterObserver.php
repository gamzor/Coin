<?php

namespace Kirill\Coins\Observer;

use Kirill\Coins\Api\Data\CoinsInterface;
use Kirill\Coins\Model\Coins;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Kirill\Coins\Model\CoinsRepository;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;
use Magento\Framework\Message\ManagerInterface;

class CustomerSaveAfterObserver implements ObserverInterface
{

    /**
     * @var CoinsRepository
     */
    protected $coinsRepository;

    /**
     *
     * @param \Kirill\Coins\Model\CoinsRepository $coinsRepository
     * @param CustomerRepository $customerRepository
     * @param LoggerInterface $logger
     * @param Session $customerSession
     * @param ManagerInterface $manager
     */
    public function __construct(
        CoinsRepository    $coinsRepository,
        CustomerRepository $customerRepository,
        LoggerInterface    $logger,
        Session            $customerSession,
        ManagerInterface   $manager
    )
    {
        $this->coinsRepository = $coinsRepository;
        $this->logger = $logger;
        $this->customerRepository = $customerRepository;
        $this->manager = $manager;
    }

    /** Save coins and change coins from form
     * @param Observer $observer
     * @param $e
     * @return \Magento\Framework\Message\Collection|ManagerInterface|void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        /* @var $request \Magento\Framework\App\RequestInterface */
        $request = $observer->getRequest();
        $coins = $request->getPost('coins');
        $customer = $observer->getCustomer();
        $customerId = $customer->getId();
        if (!($coins['amount_coins'] == "" && $coins['comment'] == "")) {
            $oldcustomerCoins = $this->getOldcustomercoins($customer);
            $balance = $this->coinsRepository->getNewInstance();
            $balance->addData(['coins' => $coins['amount_coins'], 'comment' => $coins['comment'],'customer_id' => $customerId]);
            if ($oldcustomerCoins >= 0 && $coins['amount_coins'] >= 0) {
                $savecustomerCoins = $customer->setCustomAttribute('coins',$oldcustomerCoins+$coins['amount_coins']);
                $this->customerRepository->save($savecustomerCoins);
                $this->coinsRepository->save($balance);
            }
            else $this->manager->addErrorMessage(__('Enter Correct value for coins'));
        }
        return;
    }
    /** Get Customer Coins
     * @param $customer
     * @return mixed
     */
    public function getOldcustomercoins($customer)
    {
        return $customer->getCustomAttributes()['coins']->getValue();
    }
}
