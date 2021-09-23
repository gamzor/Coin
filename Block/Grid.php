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
     * Get collection of books
     *
     * @return \Kirill\Coins\Model\ResourceModel\Coins\Collection
     */
    public function getId()
    {
        //@todo create logic for getting all records from database
        return $this->getData('id');
    }
    /**
     * Get collection of books
     *
     * @return \Kirill\Coins\Model\ResourceModel\Coins\Collection
     */
    public function getCoins()
    {
        //@todo create logic for getting all records from database
        return $this->getData('coins');
    }


    /**
     * @return string
     */
    public function getDeleteAction()
    {
        return $this->getUrl('book/index/delete', ['_secure' => true]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getEditAction($id)
    {
        return $this->getUrl('book/index/edit', ['id' => $id, '_secure' => true]);
    }

    /**
     * @return string
     */
    public function getAddAction()
    {
        return $this->getUrl('book/index/New', ['_secure' => true]);
    }

}
