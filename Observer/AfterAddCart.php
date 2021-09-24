<?php
namespace Kirill\Coins\Observer;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Checkout\Model\Cart as CustomerCart;

class AfterAddCart implements ObserverInterface
{
    protected $productRepository;
    /**
     * @var CustomerCart
     */
    private $cart;
    private $customerRepository;

    /**
     * @param CustomerCart $cart
     */
    public function __construct(
        CustomerCart $cart,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        CustomerRepository $customerRepository
    ){
        $this->cart = $cart;
        $this->_productRepository = $productRepository;
    }

    public function execute(EventObserver $observer)
    {
        $att = $this->cart->getQuote()->getCustomer()->getCustomAttribute('coins')->getValue();
        $product = $observer->getEvent()->getData('product')->getCoins();
        if ($product == 0) {
            $value = $att + $product;
            $this->customerRepository->save($value);
        }
    }
}
