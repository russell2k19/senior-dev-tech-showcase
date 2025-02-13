<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\ResourceModel;

use HarveyNorman\PromotionalProducts\Model\PromoProduct as PromoProductModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PromoProduct extends AbstractDb
{
    /**
     * PromoProduct table name
     */
    public const TABLE_PROMO_PRODUCT = "promotional_promo_product";

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_PROMO_PRODUCT,'row_id');

    }

    /**
     * Change product status
     *
     * @param array $items
     * @param int $status
     * @return $this
     */
    public function changeStatus(array $items, $status = null)
    {
        if (!empty($items) && $status !== null) {
            $condition = '`product_id` IN (' . implode(',', $items) . ')';

            if ($status == PromoProductModel::STATUS_DISABLED) {
                $this->getConnection()->delete(
                    $this->getTable(self::TABLE_PROMO_PRODUCT),
                    $condition
                );
            } else {
                $this->getConnection()->update(
                    $this->getTable(self::TABLE_PROMO_PRODUCT),
                    ['is_active' => $status],
                    $condition
                );
            }
        }

        return $this;
    }
}