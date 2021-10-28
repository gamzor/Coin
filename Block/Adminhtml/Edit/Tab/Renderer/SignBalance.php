<?php

namespace Kirill\Coins\Block\Adminhtml\Edit\Tab\Renderer;

use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;

class SignBalance extends AbstractRenderer
{
    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array   $data = []
    )
    {
        parent::__construct($context, $data);
    }
    /** Sign and color output
     * @param DataObject $row
     * @return string
     */
    public function render(DataObject $row)
    {
        return ($row->getCoins() < 0)
            ? '<span class="price" style="color:red">' . $row->getCoins() . '</span>'
            : '<span class="price" style="color:green">+' . $row->getCoins() . '</span>';
    }
}
