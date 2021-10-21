<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kirill\Coins\Controller\History;

use Magento\Framework\App\RequestInterface;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * Coins dashboard
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->_objectManager->get(\Kirill\Coins\Helper\Data::class)->isEnabled()) {
            $this->_redirect('coins/history/');
            return;
        }
        $this->_view->loadLayout();
        $this->_view->loadLayoutUpdates();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Coins'));
        $this->_view->renderLayout();
    }
}
