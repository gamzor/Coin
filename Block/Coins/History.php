<?php

namespace Kirill\Coins\Block\Coins;

use Kirill\Coins\Model\CoinsRepository;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\Session;

/**
 * Class Grid.
 */
class History extends Template implements ArgumentInterface
{
    /**
     * @var \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * Grid constructor.
     * @param Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory $collectionFactory
     * @param CoinsRepository $coinsRepository
     * @param array $data
     */
    public function __construct(
        Context           $context,
        Session           $customerSession,
        CollectionFactory $collectionFactory,
        CoinsRepository $coinsRepository,
        array             $data = []
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
        $this->coinsRepository = $coinsRepository;
        parent::__construct($context, $data);
    }
    /**
     * Get collection of coins
     *
     * @return \Kirill\Coins\Model\ResourceModel\Coins\Collection
     */
    public function getCollection()
    {
        //@todo create logic for getting all records from database
        return $this->collectionFactory->create();
    }
    /**
     * @return mixed
     */
    public function getCoinsValue()
    {
        return $this->customerSession->getCustomer()->getCoins();
    }

    /**
     * @return int|string
     */
    public function getTotal()
    {
        return $this->coinsRepository->getTotalAmount($this->customerSession->getId());
    }
}
