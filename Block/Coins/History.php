<?php

namespace Kirill\Coins\Block\Coins;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use \Magento\Customer\Model\Session;

/**
 * Class Grid.
 */
class History extends Template implements ArgumentInterface
{
    /**
     * @var \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory
     */
    private $collectionFactory;

    protected $customerSession;

    /**
     * Grid constructor.
     * @param Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context                         $context,
        Session $customerSession,
        CollectionFactory               $collectionFactory,
        array                           $data = []
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * Get collection of books
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

    /** Sum of coins
     * @return int
     */
    public function getTotal()
    {
        $total = 0;
        $collection = $this->collectionFactory->create();
        foreach ($collection as $item) {
            $sum = $item->getCoins();
            $total += $sum;
        }
        return $total;
    }
}
