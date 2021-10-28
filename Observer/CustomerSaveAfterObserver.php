<?php

namespace Kirill\Coins\Observer;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Kirill\Coins\Model\CoinsRepository;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;
use Magento\Framework\Message\ManagerInterface;

class CustomerSaveAfterObserver implements ObserverInterface
{
    /**
     * @var CoinsRepository
     */
    protected $coinsRepository;

    /**
     * @param \Kirill\Coins\Model\CoinsRepository $coinsRepository
     * @param CustomerRepository $customerRepository
     * @param LoggerInterface $logger
     * @param ManagerInterface $manager
     */
    public function __construct(
        CoinsRepository    $coinsRepository,
        CustomerRepository $customerRepository,
        ManagerInterface   $manager
    )
    {
        $this->coinsRepository = $coinsRepository;
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
        $customerId = $observer->getCustomer()->getId();
        $amount_coins = $coins['amount_coins'];
        $comment = $coins['comment'];
        if (!empty($amount_coins)) {
            $currentCustomerCoins = $this->getCurrentCustomerCoins($customer);
            if ($currentCustomerCoins + $amount_coins >= 0) {
               $this->updateCoins($customer,$amount_coins,$currentCustomerCoins);
               $this->createNewRow($amount_coins,$comment,$customerId);
            } else $this->manager->addErrorMessage(__('Enter Correct value for coins'));
        }
        return;
    }

    /** Get Current Customer Coins
     * @param $customer
     * @return int
     */
    public function getCurrentCustomerCoins($customer): int
    {
        if ($customer->getCustomAttribute('coins')) {
            return $customer->getCustomAttribute('coins')->getValue();
        }
        return 0;
    }

    /** Save coins in database
     * @param $amount_coins
     * @param $comment
     * @param $customerId
     * @return \Kirill\Coins\Api\Data\CoinsInterface|\Kirill\Coins\Model\Coins
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function createNewRow($amount_coins, $comment, $customerId)
    {
        $newCoins = $this->coinsRepository->getNewInstance();
        $newCoins->addData(['coins' => $amount_coins, 'comment' => $comment, 'customer_id' => $customerId]);
        return $this->coinsRepository->save($newCoins);
    }

    /** Save coins for customer
     * @param $customer
     * @param $amount_coins
     * @param $currentCustomerCoins
     * @return \Magento\Customer\Api\Data\CustomerInterface|void
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function updateCoins($customer,$amount_coins,$currentCustomerCoins)
    {
        if ($customer->getId()) {
            $customer->setCustomAttribute('coins', $currentCustomerCoins + $amount_coins);
            return $this->customerRepository->save($customer);
           }
        return;
    }
}
