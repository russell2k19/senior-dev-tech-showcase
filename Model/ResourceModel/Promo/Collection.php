<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo;

use HarveyNorman\PromotionalProducts\Model\Promo as ModelPromo;
use HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo as ResourceModelPromo;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = 'id';

    /**
     * Name prefix of events that are dispatched by model
     *
     * @var string
     */
    protected $_eventPrefix = 'promotional_products';

    /**
     * Name of event parameter
     *
     * @var string
     */
    protected $_eventObject = 'promo_collection';

    /**
     * Define ResourceModel
     *
     * @return void
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function _construct()
    {
        $this->_init(ModelPromo::class, ResourceModelPromo::class);
    }

    /**
     * Load by product ids
     *
     * @param array $ids
     * @return $this
     */
    public function loadByProductIds($ids)
    {
        $cond = implode(',', $ids);
        $this->getSelect()->joinLeft(
            ['promo_product' => $this->getTable('promotional_promo_product')],
            "main_table.id = promotional_promo_product.id
            WHERE promotional_promo_product.product_id IN ($cond)
            "
        )->group('main_table.id');

        return $this;
    }
}