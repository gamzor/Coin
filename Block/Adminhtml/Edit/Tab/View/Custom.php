<?php

namespace Kirill\Coins\Block\Adminhtml\Edit\Tab\View;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\Registry;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;

class Custom extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_coreRegistry = null;

    protected $collectionFactory;

    public function __construct(
        Context           $context,
        Data              $backendHelper,
        CollectionFactory $collectionFactory,
        Registry          $coreRegistry,
        array             $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected
    function _construct()
    {
        parent::_construct();
        $this->setId('coins');
        $this->setDefaultSort('created_at', 'desc');
        $this->setSortable(false);
        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);
    }

    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            ['header' => __('ID'), 'index' => 'id', 'type' => 'number', 'width' => '100px']
        );
        $this->addColumn(
            'order_id',
            [
                'header' => __('Order Id'),
                'index' => 'order_id',
            ]
        );
        $this->addColumn(
            'coins',
            [
                'header' => __('Coins'),
                'index' => 'coins',
            ]
        );
        $this->addColumn(
            'comment',
            [
                'header' => __('Comment'),
                'index' => 'comment',
            ]
        );
        $this->addColumn(
            'Insertion Date',
            [
                'header' => __('Insertion Date'),
                'index' => 'insertion_date',
            ]
        );
        return parent::_prepareColumns();
    }

    public function getHeadersVisibility()
    {
        return $this->getCollection()->getSize() >= 0;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('catalog/product/edit', ['id' => $row->getProductId()]);
    }

    public function getTitle()
    {
        return $this->pageTitle->getShort();
    }
}
