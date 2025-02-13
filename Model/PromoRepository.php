<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model;

use HarveyNorman\PromotionalProducts\Api\Data\PromoInterface;
use HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface;
use HarveyNorman\PromotionalProducts\Model\PromoFactory;
use HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo as ResourcePromo;
use HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\CollectionFactory as PromoCollectionFactory;
use HarveyNorman\PromotionalProducts\Api\Data\PromoSearchResultsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Promo Repository model
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PromoRepository implements PromoRepositoryInterface
{
    /**
     * @var ResourcePromo
     */
    protected $resource;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\PromoFactory
     */
    protected $promoFactory;

    /**
     * @var PromoCollectionFactory
     */
    protected $promoCollectionFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var PromoSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * Promo Repository Constructor
     *
     * @param \HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo $resource
     * @param \HarveyNorman\PromotionalProducts\Model\PromoFactory $promoFactory
     * @param \HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\CollectionFactory $websiteCollectionFactory
     * @param \Magento\Framework\Api\DataObjectHelper  $dataObjectHelper
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Store\Model\StoreManagerInterface  $storeManager
     * @param \HarveyNorman\PromotionalProducts\Api\Data\PromoSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ResourcePromo $resource,
        PromoFactory $promoFactory,
        PromoCollectionFactory $websiteCollectionFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        PromoSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->promoFactory = $promoFactory;
        $this->promoCollectionFactory = $websiteCollectionFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Promo
     *
     * @param \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface $promo
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     * @throws CouldNotSaveException
     */
    public function save(PromoInterface $promo)
    {
        try {
            $this->resource->save($promo);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the promo: %1',
                    $exception->getMessage()
                )
            );
        }
        return $promo;
    }

    /**
     * Get Promo by ID
     *
     * @param $promoId
     * @return Promo|mixed
     * @throws NoSuchEntityException
     */
    public function getById($promoId)
    {
        $promo = $this->promoFactory->create();
        $this->resource->load($promo, $promoId);
        if (!$promo->getId()) {
            throw new NoSuchEntityException(__('promo with id "%1" does not exist.', $promoId));
        }
        return $promo;
    }

    /**
     * Get Id By Name
     *
     * @param $promoName
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getIdByName($promoName)
    {
        $promoId = $this->resource->getIdByName($promoName);
        if (!$promoId) {
            throw new NoSuchEntityException(__('promo with name "%1" does not exist.', $promoName));
        }
        return $promoId;
    }

    /**
     * Delete Promo action
     *
     * @param PromoInterface $promo
     * @return true
     * @throws CouldNotDeleteException
     */
    public function delete(PromoInterface $promo)
    {
        try {
            $this->resource->delete($promo);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __(
                    'Could not delete the Promo: %1',
                    $exception->getMessage()
                )
            );
        }
        return true;
    }

    /**
     * Delete using promo id
     *
     * @param $promoId
     * @return true
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($promoId)
    {
        return $this->delete($this->getById($promoId));
    }

    /**
     * Retrieve Promo matching the specified criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->promoCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
