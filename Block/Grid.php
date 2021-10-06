<?php

namespace Kirill\Coins\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\Session;

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
     * @var \Magento\Customer\Model\Session
     */
    protected $_session;
    /**
     * Grid constructor.
     * @param Template\Context $context
     * @param \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        Session $session,
        array             $data = []

    )
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
        $this->_session = $session;
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
     * Get collection of coins
     *
     * @return \Kirill\Coins\Model\ResourceModel\Coins\Collection
     */
    public function getId()
    {
        //@todo create logic for getting all records from database
        return $this->getData('id');
    }
    /**
     * Get collection of coins
     *
     * @return \Kirill\Coins\Model\ResourceModel\Coins\Collection
     */
    public function getCoins()
    {
        //@todo create logic for getting all records from database
        return $this->getData('coins');
    }
}
