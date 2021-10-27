<?php
namespace Kirill\Coins\Model;

use Kirill\Coins\Api\CoinsRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Kirill\Coins\Model\ResourceModel\Coins as ResourceCoins;
use Kirill\Coins\Api\Data\CoinsInterface;
use Kirill\Coins\Model\CoinsFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class BooksRepository. CRUD's operation with object
 */
class CoinsRepository implements CoinsRepositoryInterface
{

    /**
     * @var \Kirill\Coins\Model\ResourceModel\Coins
     */
    private $resource;

    /**
     * @var \Kirill\Coins\Model\CoinsFactory
     */
    private $coinsFactory;
    /**
     * @var ResourceCoins\CollectionFactory
     */
    private $collectionFactory;

    /**
     * CoinsRepository constructor.
     * @param \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory $collectionFactory
     * @param \Kirill\Coins\Model\ResourceModel\Coins $resource
     * @param \Kirill\Coins\Model\CoinsFactory $coinsFactory
     */
    public function __construct(
        ResourceCoins $resource,
        CoinsFactory $coinsFactory,
        \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory $collectionFactory
    ) {
        $this->resource = $resource;
        $this->coinsFactory = $coinsFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Save coins data
     *
     * @param \Kirill\Coins\Api\Data\CoinsInterface $coins
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(CoinsInterface $coins)
    {
        try {
            /** @var \Kirill\Coins\Model\Coins $coins */
            $this->resource->save($coins);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $coins;
    }

    /**
     * Retrieve book.
     *
     * @param int $coinsId
     * @return CoinsInterface|ResourceCoins
     */
    public function getById($coinsId)
    {
        $block = $this->coinsFactory->create();
        $block->getResource()->load($block, $coinsId);
        if (! $block->getId()) {
            throw new NoSuchEntityException(__('Unable to find coins with ID "%1"', $coinsId));
        }
        return $block;
    }

    /**
     * Delete Book
     *
     * @param \Kirill\Coins\Api\Data\CoinsInterface $coins
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CoinsInterface $coins)
    {
        try {
            /** @var \Kirill\Coins\Model\Coins $coins */
            $this->resource->delete($coins);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Block by given Block Identity
     *
     * @param int $coinsId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($coinsId)
    {
        return $this->delete($this->getById($coinsId));
    }

    /**
     * Get clear model
     *
     * @return Coins
     */
    public function getNewInstance()
    {
        return $this->coinsFactory->create();
    }
    public function getTotalAmount($customerId)
    {
       return $this->resource->getTotalAmount($customerId) ? : 0;
    }
}
