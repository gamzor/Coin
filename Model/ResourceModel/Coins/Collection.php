<?php
namespace Kirill\Coins\Model\ResourceModel\Coins;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'coins_collection';
    protected $_eventObject = 'coins_collection';
    /** Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Kirill\Coins\Model\Coins', 'Kirill\Coins\Model\ResourceModel\Coins');
    }
}
