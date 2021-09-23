<?php
namespace Kirill\Coins\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\Product;
class ProccesOrder implements ObserverInterface {

    private $logger;
    private $product;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        Product $product
    ){
        $this->logger = $logger;
        $this->product = $product;
    }


    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $product = $this->product->getId();
        $customerId = $order->getCustomerId();
        $this->logger->info('Catched event succssfully');

    }
}
