<?php

namespace Kirill\Coins\Controller\Adminhtml\Index;

use Magento\Customer\Controller\Adminhtml\Index;
class Custom extends Index
{
    /**
     * Customer compare grid
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initCurrentCustomer();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}

