<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Fields extends AbstractModifier
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Modifier constructor
     *
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Data Modifier
     *
     * @param array $data
     * @return array|void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function modifyData(array $data)
    {
        foreach ($data as $key => $item) {
            if (array_key_exists('product', $item)) {
                $productId = $item['product']['current_product_id'];
                if (!$productId) {
                    continue;
                }
                $promo = $this->productRepository->getById($productId)->getPromo();
                if ($promo) {
                    $data[$key]['promo']['promo'] = $promo->getId();
                }
            }
        }
        return $data;
    }

    /**
     * Meta Modifier
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}