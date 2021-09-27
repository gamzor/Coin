<?php
namespace Kirill\Coins\Model;
class Coins extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'coins';

    protected $_cacheTag = 'coins';

    protected $_eventPrefix = 'coins';
    private $coinsFactory;

    protected function _construct()
    {
        $this->_init('Kirill\Coins\Model\ResourceModel\Coins');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
    public function getNewInstance()
    {
        return $this->booksFactory->create();
    }
}
