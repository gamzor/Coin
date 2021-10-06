<?php

namespace Kirill\Coins\Block\Adminhtml\Edit\Tab\View;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;
use Magento\Backend\Block\Widget\Grid\Extended;
class Grid extends Extended
{
    /**
     * @var Registry|null
     */
    protected $_coreRegistry = null;
    /**
     * @var CollectionFactory
     */
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
        $this->setEmptyText('No Coins Change');
    }

    /** Collection on Grid
     *
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /** Prepare grid columns
     *
     * @return Grid
     * @throws \Exception
     */
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
                'renderer' => 'Kirill\Coins\Block\Adminhtml\Edit\Tab\Renderer\SignBalance'
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
}
