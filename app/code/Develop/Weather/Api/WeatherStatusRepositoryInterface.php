<?php

declare(strict_types=1);

namespace Develop\Weather\Api;

use Develop\Weather\Api\Data\WeatherStatusInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;

interface WeatherStatusRepositoryInterface
{
    /**
     * @param WeatherStatusInterface $weatherStatus
     * @return WeatherStatusInterface
     * @throws CouldNotSaveException
     */
    public function save(WeatherStatusInterface $weatherStatus): WeatherStatusInterface;

    /**
     * @param int $id
     * @return WeatherStatusInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherStatusInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @return WeatherStatusInterface
     * @throws NoSuchEntityException
     */
    public function getLast(): WeatherStatusInterface;

    /**
     * @param WeatherStatusInterface $weatherStatus
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(WeatherStatusInterface $weatherStatus): bool;

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool;
}
