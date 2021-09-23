<?php
namespace Kirill\Coins\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Checkout\Model\Cart as CustomerCart;

class AfterAddCart implements ObserverInterface
{
    /**
     * @var CustomerCart
     */
    private $cart;

    private $logger;
    /**
     * @param CustomerCart $cart
     */
    public function __construct(
        CustomerCart $cart,
        \Psr\Log\LoggerInterface $logger
    ){
        $this->cart = $cart;
        $this->logger = $logger;
    }

    public function execute(EventObserver $observer)
    {
        $this->cart->getQuote()->getId();
        $this->logger->alert('HOT');
    }
}
