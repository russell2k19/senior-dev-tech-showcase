<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Serialize\Serializer\Json;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**#@+
     * Promotional Product Constants
     *
     * @type string
     */
    private const PAYLOAD_BASE_MAP = [
        'product_id' => 'id',
        'sku' => 'sku',
        'name' => 'name',
        'original_price' => 'price',
        'discounted_price' => 'special_price',
        'stock_qty' => 'qty',
        'categories' => 'categories',
        'attributes' => 'attributes',
        'visibility' => 'visibility',
        'is_in_stock' => '',
        'updated_at' => ''

    ];

    public const PROMOTIONAL_PRODUCT_ATTRIBUTES = [
        'hn_promotion_id' => 'Promotion ID',
        'hn_promotion_name' => 'Promotion Name',
        'hn_promotion_type' => 'Promotion type',
        'hn_promotion_value' => 'Promotion Value',
        'hn_promotion_start_date' => 'Promotion Start Date',
        'hn_promotion_end_date' => 'Promotion End Date'
    ];
    /**#@- */

    /**
     * @var Json
     */
    private Json $jsonHelper;

    /**
     * @param Context $context
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonHelper
     */
    public function __construct(
        Context $context,
        Json $jsonHelper
    ) {
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }

    /**
     * Get multiple Attribute Values from product
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param array $arrAttrCodes
     * @return array
     */
    public function getAttrValByCode($product, $arrAttrCodes)
    {
        $arrValues = [];
        foreach ($product->getAttributes() as $attribute) {
            $attrCode = $attribute->getAttributeCode();
            if (in_array($attrCode, array_keys($arrAttrCodes))) {
                $arrValues[$attrCode] = $attribute->getFrontend()->getValue($product);
            }

            if (sizeof($arrValues) == sizeof($arrAttrCodes)) {
                return $arrValues;
            }
        }

        return $arrValues;
    }

    /**
     * Parse Promotional Data
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function parsePromotionalData($product)
    {
        $promotionalData = $this->getAttrValByCode($product, self::PROMOTIONAL_PRODUCT_ATTRIBUTES);
        $baseData = [
            'product_id' => $product->getId(),
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'original_price' => $product->getPrice(),
            'discounted_price' => $product->getSpecialPrice(),
            'stock_qty' => $product->getQty(),
            'categories' => $product->getCategoryIds(),
            'attributes' => 'attributes',
            'visibility' => $product->getVisibility(),
            'is_in_stock' => 'is_in_stock',
            'updated_at' => $product->getUpdatedAt()
        ];
        $baseData['promotion'] = $promotionalData;
        return $this->jsonHelper->serialize($baseData);
    }
}