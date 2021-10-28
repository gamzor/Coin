<?php
namespace Kirill\Coins\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use \Magento\Framework\Model\ResourceModel\Db\Context;
class Coins extends AbstractDb
{
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('coins', 'id');
    }
    /** Get total amount of coins
     * @param int $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTotalAmount($customerId)
    {
        $connection = $this->getConnection();
        $tableName = $this->getMainTable();

        $select = $connection->select()->from($tableName,'SUM(coins)')->where('customer_id = :customer_id');
        $bind = ['customer_id' => $customerId];
        $amount =  $connection->fetchOne($select,$bind);
        return max(0,$amount);
    }
}
