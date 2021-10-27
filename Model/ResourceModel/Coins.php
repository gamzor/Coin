<?php
namespace Kirill\Coins\Model\ResourceModel;


class Coins extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('coins', 'id');
    }
    /**
     * Get total amount of coins
     *
     * @param int $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTotalAmount($customerId)
    {
        $connection = $this->getConnection();
        return $connection->fetchOne(
            $connection->select()->from(
                $this->getMainTable(),
                'SUM(coins)'
            )->where(
                'customer_id = :customer_id'
            ),
            ['customer_id' => $customerId]
        );
    }
}
