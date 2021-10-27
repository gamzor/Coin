<?php

namespace Kirill\Coins\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Grid.
 */
class Grid extends Template implements ArgumentInterface
{
    /**
     * @var \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory
     */
    private $collectionFactory;
    /**
     * Grid constructor.
     * @param Template\Context $context
     * @param \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        array             $data = []

    )
    {
        $this->collectionFactory = $collectionFactory;
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
    /** Get Total coins for customer
     * @return int
     */
    public function getTotal(): int
    {
        $total = 0;
        $collection = $this->getCollection();
        foreach ($collection as $item) {
            $sum = $item->getCoins();
            $total += $sum;
        }
        return $total;
    }

    /** Sign value attribute coins
     * @param $item
     * @return string
     */
    public function getSignCoins($item)
    {
        return  ($item->getCoins()<0)
            ? '<span class="price" style="color:red">' . $item->getCoins() . '</span>'
            : '<span class="price" style="color:green">+' . $item->getCoins() . '</span>';
    }

}
