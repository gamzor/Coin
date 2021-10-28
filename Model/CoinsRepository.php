<?php
namespace Kirill\Coins\Model;

use Kirill\Coins\Api\CoinsRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Kirill\Coins\Model\ResourceModel\Coins as ResourceCoins;
use Kirill\Coins\Api\Data\CoinsInterface;
use Kirill\Coins\Model\CoinsFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use \Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;
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
        CollectionFactory $collectionFactory
    ) {
        $this->resource = $resource;
        $this->coinsFactory = $coinsFactory;
        $this->collectionFactory = $collectionFactory;
    }
    /** Save coins data
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
    /** Retrieve coins
     * @param int $coinsId
     * @return CoinsInterface|ResourceCoins
     * @throws NoSuchEntityException
     */
    public function getById($coinsId)
    {
        $coins = $this->coinsFactory->create();
        $coins->resource->load($coins, $coinsId);
        if (! $coins->getId()) {
            throw new NoSuchEntityException(__('Unable to find coins with ID "%1"', $coinsId));
        }
        return $coins;
    }
    /**
     * Delete Coins
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
    /** Get total amount coins
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTotalAmount($customerId)
    {
       return $this->resource->getTotalAmount($customerId);
    }
}
