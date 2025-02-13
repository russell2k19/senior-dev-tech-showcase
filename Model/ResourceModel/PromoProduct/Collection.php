<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\ResourceModel\PromoProduct;

use HarveyNorman\PromotionalProducts\Model\PromoProduct as ModelPromoProduct;
use HarveyNorman\PromotionalProducts\Model\ResourceModel\PromoProduct as ResourceModelPromoProduct;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = 'row_id';

    /**
     * Define ResourceModel
     *
     * @return void
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function _construct()
    {
        $this->_init(ModelPromoProduct::class, ResourceModelPromoProduct::class);
    }
}