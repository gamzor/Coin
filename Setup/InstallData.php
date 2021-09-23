<?php
namespace Kirill\Coins\Setup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class InstallData implements InstallDataInterface
{
    protected $_exampleFactory;

    private EavSetupFactory $eavSetupFactory;

    public function __construct(\Kirill\Coins\Model\CoinsFactory $exampleFactory, EavSetupFactory $eavSetupFactory)
    {
        $this->_exampleFactory = $exampleFactory;
        $this->eavSetupFactory = $eavSetupFactory;
    }
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = ['coins' => '200'];
        $example = $this->_exampleFactory->create();
        $example->addData($data)->save();

        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'coins',
            [
                'label' => 'Reward Point',
                'type' => 'decimal',
                'input' => 'price',
                'required' => false,
                'sort_order' => 30,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'used_in_product_listing' => true,
                'visible_on_front' => true
            ]
        );
        $setup->endSetup();
    }
}
