<?php
namespace Kirill\Coins\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema. Create an additional table
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('coins')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('coins')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )->addColumn(
                'order_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'ORDER ID'
            )->addColumn(
                'customer_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Customer ID'
            )->addColumn(
                'comment',
                Table::TYPE_INTEGER,
                255,
                ['nullable' => false],
                'Comment')
            ->addColumn(
                'coins',
                Table::TYPE_INTEGER,
                255,
                ['nullable' => false],
                'Coins')
            ->addColumn(
                'insertion_date',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Insertion Date')

                ->setComment('Coins');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
