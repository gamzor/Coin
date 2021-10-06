<?php
namespace Kirill\Coins\Block;

use Kirill\Coins\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class CoinAttribute extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        Data $helper,
        array $data)
    {
        $this->registry = $registry;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if ($this->product === null) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }
    public function isEnabled()
    {
        return $this->helper->isEnabled();
    }
    public function getPercent()
    {
        return $this->helper->getPercent();
    }
}
