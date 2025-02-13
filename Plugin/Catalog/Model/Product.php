<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Plugin\Catalog\Model;

use HarveyNorman\PromotionalProducts\Model\ResourceModel\PromoProduct\CollectionFactory;
use Magento\Catalog\Model\Product as ProductModel;
use HarveyNorman\PromotionalProducts\Model\PromoRepository;

/**
 * Product model plugin
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Product
{
    /**
     * @var \HarveyNorman\PromotionalProducts\Model\ResourceModel\PromoProduct\Collection
     */
    protected $promoProductCollection;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\PromoRepository
     */
    protected $promoRepository;

    /**
     * @param \HarveyNorman\PromotionalProducts\Model\ResourceModel\PromoProduct\CollectionFactory $promoProductCollectionFactory
     * @param \HarveyNorman\PromotionalProducts\Model\PromoRepository $promoRepository
     */
    public function __construct(
        CollectionFactory $promoProductCollectionFactory,
        PromoRepository $promoRepository
    ) {
        $this->promoProductCollection = $promoProductCollectionFactory->create();
        $this->promoRepository = $promoRepository;
    }


    /**
     * Add Promo model to Product Data
     *
     * @param \Magento\Catalog\Model\Product $subject
     * @param \Magento\Catalog\Model\Product $result
     * @return mixed
     */
    public function afterLoad(ProductModel $subject, $result)
    {
        $productId = $subject->getId();
        try {
            $promoProduct = $this->promoProductCollection
                ->addFieldToFilter('product_id', ['eq' => $productId])
                ->getFirstItem();
            if ($promoProduct) {
                $promo = $this->promoRepository->getById($promoProduct->getPromoId());
                $result->setPromo($promo);
            }
        } catch (\Exception $e) {
            $result->setPromo(null);
        }

        return $result;
    }
}