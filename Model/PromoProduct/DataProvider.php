<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\PromoProduct;

use HarveyNorman\PromotionalProducts\Model\ResourceModel\PromoProduct\CollectionFactory as PromoProductCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * PromoProduct data provider model
 *
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.LongVariable)
 * @since 101.0.0
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\ResourceModel\PromoProduct\Collection
     */
    protected $promoProductCollection;

    /**
     * DataProvider Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectioFactory
     * @param RequestInterface $request
     * @param PromoProductCollectionFactory $promoProductCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectioFactory,
        RequestInterface $request,
        PromoProductCollectionFactory $promoProductCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectioFactory->create();
        $this->request = $request;
        $this->promoProductCollection = $promoProductCollectionFactory;
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $items = $this->getCollection()->toArray();

        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items),
        ];
    }

    /**
     * Return collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getCollection()
    {
        /**
         * @var Collection $collection
         */
        $collection = parent::getCollection();
        $collection->addAttributeToSelect('status');

        if (!$this->getCurrentPromoId()) {
            return $collection;
        }

        return $this->addCollectionFilters($collection);
    }


    /**
     * Add collection filters
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected function addCollectionFilters(Collection $collection)
    {
        /** constraints is 1 promo per product only */
        if (($this->getLinkedProductsIds())) {
            $collection->addFieldToFilter(
                $collection->getIdFieldName(),
                ['nin' => [$this->getLinkedProductsIds()]]
            );
        }

        return $collection;
    }

    /**
     * Retrieve current promo id
     *
     * @return int|null
     */
    protected function getCurrentPromoId()
    {
        return $this->request->getParam('current_promo_id');
    }

    /**
     * Get Product ids already linked to another promo
     *
     * @return array|null
     */
    public function getLinkedProductsIds()
    {
        $ids = null;
        $this->promoProductCollection
            ->addFieldToSelect('product_id')
            ->addFieldToFilter('id', ['neq' => $this->getCurrentPromoId()]);
        foreach ($this->promoProductCollection as $item) {
            $ids[] = $item->getProductId();
        }
        return $ids;
    }
}