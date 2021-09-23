<?php

namespace Kirill\Coins\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $_coinsFactory;

    public function __construct(\Kirill\Coins\Model\CoinsFactory $coinsFactory)
    {
        $this->_coinsFactory = $coinsFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0', '<'))
        {
            $data = [
                'coins' => '-100',];
            $example = $this->_coinsFactory->create();
            $example -> addData($data)->save();
        }
    }
}
