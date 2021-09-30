<?php
namespace Kirill\Coins\Controller\history;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Customer\Controller\AbstractAccount implements HttpGetActionInterface
{
    protected $moduleManager;
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->moduleManager = $moduleManager;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if ($this->moduleManager->isOutputEnabled('Vendor_Module')) {
            //the module output is enabled
        } else {
            //the module output is disabled
        }
        return $this->resultPageFactory->create();
    }
}
