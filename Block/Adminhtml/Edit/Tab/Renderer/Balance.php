<?php

namespace Kirill\Coins\Block\Adminhtml\Edit\Tab\Renderer;

use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Catalog\Helper\Image;
use Magento\Framework\DataObject;
use Magento\Store\Model\StoreManagerInterface;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;

class Balance extends AbstractRenderer
{
    private $_storeManager;
    private $imageHelper;
    private $collectionFactory;

    public function __construct(
        Context $context,
        Image $imageHelper,
        StoreManagerInterface $storemanager,
        CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        $this->_storeManager = $storemanager;
        parent::__construct($context, $data);
        $this->_authorization = $context->getAuthorization();
        $this->imageHelper = $imageHelper;
        $this->collectionFactory = $collectionFactory;
    }

    public function render(DataObject $row)
    {
        if ($row->getCoins()<0) {
            $difference = '<span class="price" style="color:red">' . $row->getCoins() . '</span>';
        } else {
            $difference = '<span class="price" style="color:green">+' . $row->getCoins() . '</span>';
        }
        return $difference;
    }
}
