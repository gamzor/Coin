<?php
namespace Kirill\Coins\Api\Data;

use Magento\Tests\NamingConvention\true\mixed;

/**
 * Interface BooksInterface. Retrieve books data
 */
interface CoinsInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const COINS_ID = 'id';
    const COINS_ORDER_ID = 'order_id';
    const COINS_CUSTOMER_ID = 'customer_id';
    const COINS_COMMENT = 'comment';
    const COINS_COINS = 'coins';
    const COINS_INSERTION_DATE = 'insertion_date';
    /**#@-*/

    /**
     * Get Id
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get order id
     *
     * @return mixed
     */
    public function getOrderId();

    /**
     * Get customer id
     *
     * @return mixed
     */
    public function getCustomerId();

    /**
     * Get comment
     *
     * @return mixed
     */
    public function getComment();

    /**
     * Get coins
     *
     * @return mixed
     */
    public function getCoins();
    /**
     * Get insertion date
     *
     * @return mixed
     */
    public function getInsertionDate();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     */
    public function setId($id);

    /**
     * Set order id
     *
     * @param int $orderid
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     */
    public function setOrderId($orderid);

    /**
     * Set customer id
     *
     * @param int $customerid
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     */
    public function setCustomerId($customerid);

    /**
     * Set comment
     *
     * @param string $comment
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     */
    public function setComment(string $comment);

    /**
     * Set coins
     *
     * @param int $coins
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     */
    public function setCoins($coins);
    /**
     * Set coins
     *
     * @param int $insertionDate
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     */
    public function setInsertionDate($insertionDate);
}
