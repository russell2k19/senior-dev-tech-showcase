<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\Adapter\BatchDataMapper;

use Magento\AdvancedSearch\Model\Adapter\DataMapper\AdditionalFieldsProviderInterface;
use Magento\Catalog\Model\ProductRepository;
use HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\CollectionFactory;

class PromoDataProvider implements AdditionalFieldsProviderInterface
{
    /**
     * Promo field name
     */
    public const FIELD_NAME = 'promo';

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\CollectionFactory $collectionFactory
     */
    public function __construct(
        ProductRepository $productRepository,
        CollectionFactory $collectionFactory
    ) {
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getFields(array $productIds, $storeId)
    {
        $fields = [];
        foreach ($productIds as $productId) {
            $product = $this->productRepository->getById($productId);
            if (!empty($product)) {
                $fields[$productId][self::FIELD_NAME] = $this->getOptions($product);
            }
        }

        return $fields;
    }

    /**
     * Get series options from the product
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return array|false
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function getOptions($product)
    {
        $brands = $this->collectionFactory->create()
            ->loadByProductIds([$product->getId()]);
        if (!$brands->getItems()) {
            return [];
        }
        $ids = [];
        foreach ($brands->getAllIds() as $id) {
            $ids[] = (int)$id;
        }
        return $ids;
    }
}
