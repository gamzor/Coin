<?php

namespace Kirill\Coins\Model;

use Kirill\Coins\Api\Data\CoinsInterface;
use Magento\Framework\Model\AbstractModel;

class Coins extends AbstractModel implements CoinsInterface
{
    const CACHE_TAG = 'coins';
    protected $_cacheTag = 'coins';
    protected $_eventPrefix = 'coins';


    protected function _construct()
    {
        $this->_init('Kirill\Coins\Model\ResourceModel\Coins');
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::COINS_ID);
    }

    /**
     * @inheritdoc
     */
    public function getOrderId()
    {
        return $this->getData(self::COINS_ORDER_ID);
    }
    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::COINS_CUSTOMER_ID);
    }
    /**
     * @inheritdoc
     */
    public function getCoins()
    {
        return $this->getData(self::COINS_COINS);
    }
    /**
     * @inheritdoc
     */
    public function getComment()
    {
        return $this->getData(self::COINS_COMMENT);
    }
    /**
     * @inheritdoc
     */
    public function getInsertionDate()
    {
        return $this->getData(self::COINS_INSERTION_DATE);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::COINS_ID, $id);
    }
    /**
     * @inheritdoc
     */
    public function setOrderId($orderid)
    {
        return $this->setData(self::COINS_ORDER_ID, $orderid);
    }
    /**
     * @inheritdoc
     */
    public function setCustomerId($customerid)
    {
        return $this->setData(self::COINS_CUSTOMER_ID, $customerid);
    }
    /**
     * @inheritdoc
     */
    public function setComment($comment)
    {
        return $this->setData(self::COINS_COMMENT, $comment);
    }
    /**
     * @inheritdoc
     */
    public function setCoins($coins)
    {
        return $this->setData(self::COINS_COINS, $coins);
    }
    /**
     * @inheritdoc
     */
    public function setInsertionDate($insertionDate)
    {
        return $this->setData(self::COINS_INSERTION_DATE, $insertionDate);
    }
}
