<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\ResourceModel;

use HarveyNorman\PromotionalProducts\Api\Data\PromoInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Promo extends AbstractDb
{
    /**
     * Table name
     */
    public const DB_SCHEMA_TABLE_PROMO = 'promotional_promo';

    /**
     * Constructor
     *
     * @param Context $context
     * @param $connectionName
     */
    public function __construct(
        Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::DB_SCHEMA_TABLE_PROMO, PromoInterface::PROMO_ID);
    }
}