<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\Product\Grid;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

/**
 * Promo Product grid dataprovider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     */
    protected $collectionFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create()
            ->addAttributeToSelect(
                'sku'
            )->addAttributeToSelect(
                'name'
            )->addAttributeToSelect(
                'attribute_set_id'
            )->addAttributeToSelect(
                'type_id'
            )->addAttributeToSelect(
                'price'
            );

        $this->collection->joinField(
            'qty',
            'cataloginventory_stock_item',
            'qty',
            'product_id=entity_id',
            '{{table}}.stock_id=1',
            'left'
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $arrItems = [];
        $arrItems['totalRecords'] = $this->collection->getSize();
        $arrItems['items'] = [];
        $arrItems['allIds'] = $this->collection->getAllIds();

        foreach ($this->collection->getItems() as $item) {
            $arrItems['items'][] =  $item->toArray();
        }

        return $arrItems;
    }
}