<?php

declare(strict_types=1);

namespace Develop\Weather\Model;

use Develop\Weather\Api\Data\WeatherStatusInterface;
use Develop\Weather\Api\Data\WeatherStatusInterfaceFactory;
use Develop\Weather\Api\WeatherStatusRepositoryInterface;
use Develop\Weather\Model\ResourceModel\WeatherStatus as WeatherStatusResourceModel;
use Develop\Weather\Model\ResourceModel\WeatherStatus\CollectionFactory as WeatherStatusCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Exception;

/**
 * @package develop/weather
 */
class WeatherStatusRepository implements WeatherStatusRepositoryInterface
{
    /**
     * @var WeatherStatusInterfaceFactory
     */
    protected WeatherStatusInterfaceFactory $weatherStatusFactory;

    /**
     * @var WeatherStatusResourceModel
     */
    protected WeatherStatusResourceModel $weatherStatusResource;

    /**
     * @var WeatherStatusCollectionFactory
     */
    protected WeatherStatusCollectionFactory $weatherStatusCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected SearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected SortOrderBuilder $sortOrderBuilder;

    /**
     * @param WeatherStatusInterfaceFactory $weatherStatusFactory
     * @param WeatherStatusResourceModel $weatherStatusResource
     * @param WeatherStatusCollectionFactory $weatherStatusCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        WeatherStatusInterfaceFactory $weatherStatusFactory,
        WeatherStatusResourceModel $weatherStatusResource,
        WeatherStatusCollectionFactory $weatherStatusCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->weatherStatusFactory = $weatherStatusFactory;
        $this->weatherStatusResource = $weatherStatusResource;
        $this->weatherStatusCollectionFactory = $weatherStatusCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @param WeatherStatusInterface $weatherStatus
     * @return WeatherStatusInterface
     * @throws CouldNotSaveException
     */
    public function save(WeatherStatusInterface $weatherStatus): WeatherStatusInterface
    {
        try {
            $this->weatherStatusResource->save($weatherStatus);
        } catch (LocalizedException $error) {
            throw new CouldNotSaveException(__($error->getMessage()), $error);
        } catch (Exception $error) {
            throw new CouldNotSaveException(__("Unable to save provided entity."), $error);
        }

        return $weatherStatus;
    }

    /**
     * @param int $id
     * @return WeatherStatusInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherStatusInterface
    {
        $weatherStatus = $this->weatherStatusFactory->create();

        try {
            $this->weatherStatusResource->load($weatherStatus, $id);
        } catch (LocalizedException $error) {
            throw $error;
        } catch (Exception $error) {
            throw new LocalizedException(__("Unable to load entity."), $error);
        }

        if (!$weatherStatus->getId()) {
            throw new NoSuchEntityException(
                __("Unable to load entity.")
            );
        }

        return $weatherStatus;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $weatherStatusCollection = $this->weatherStatusCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $weatherStatusCollection);

        $weatherStatusCollection->load();

        $searchResult = $this->searchResultsFactory->create();

        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($weatherStatusCollection->getItems());
        $searchResult->setTotalCount($weatherStatusCollection->getSize());

        return $searchResult;
    }

    /**
     * @return WeatherStatusInterface
     * @throws NoSuchEntityException
     */
    public function getLast(): WeatherStatusInterface
    {
        $this->sortOrderBuilder->setField('created_at');
        $this->sortOrderBuilder->setDescendingDirection();
        $sortOrder = $this->sortOrderBuilder->create();

        $this->searchCriteriaBuilder->addSortOrder($sortOrder);

        $this->searchCriteriaBuilder->setPageSize(1);
        $this->searchCriteriaBuilder->setCurrentPage(1);

        $searchCriteria = $this->searchCriteriaBuilder->create();

        $searchResult = $this->getList($searchCriteria);
        $itemList = $searchResult->getItems();

        if (empty($itemList) || !is_array($itemList)) {
            throw new NoSuchEntityException(
                __('Unable to load entity.')
            );
        }

        return $itemList[array_keys($itemList)[0]];
    }

    /**
     * @param WeatherStatusInterface $weatherStatus
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(WeatherStatusInterface $weatherStatus): bool
    {
        try {
            $this->weatherStatusResource->delete($weatherStatus);
        } catch (LocalizedException $error) {
            throw new CouldNotDeleteException(__($error->getMessage()), $error);
        } catch (Exception $error) {
            throw new CouldNotDeleteException(__("Unable to delete provided entity."), $error);
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws LocalizedException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool
    {
        try {
            $weatherStatus = $this->getById($id);
            $this->weatherStatusResource->delete($weatherStatus);
        } catch (LocalizedException $error) {
            throw new CouldNotDeleteException(__($error->getMessage()), $error);
        } catch (Exception $error) {
            throw new CouldNotDeleteException(__("Unable to delete entity."), $error);
        }

        return true;
    }
}
