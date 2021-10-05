<?php
namespace Kirill\Coins\Api;

use Kirill\Coins\Api\Data\CoinsInterface;

/**
 * Interface CoinsRepositoryInterface.
 */
interface CoinsRepositoryInterface
{
    /**
     * Save coins.
     *
     * @param \Kirill\Coins\Api\Data\CoinsInterface $coins
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(CoinsInterface $coins);

    /**
     * Retrieve coins.
     *
     * @param int $coinsId
     * @return \Kirill\Coins\Api\Data\CoinsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($coinsId);

    /**
     * Delete coins.
     *
     * @param \Kirill\Coins\Api\Data\CoinsInterface $coins
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(CoinsInterface $coins);

    /**
     * Delete coins by ID.
     *
     * @param int $coinsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($coinsId);

}
