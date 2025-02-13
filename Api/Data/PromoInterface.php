<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Api\Data;

interface PromoInterface
{
    /**#@+
     * Config constants
     *
     * @type string
     */
    public const PROMO_ID = 'id';
    public const PROMO_NAME = 'name';
    public const PROMO_TYPE = 'type';
    public const PROMO_VALUE = 'value';
    public const PROMO_START = 'start_date';
    public const PROMO_END = 'end_date';
    public const PROMO_STATUS = 'status';

    public const PROMO_PRODUCTS = 'promotional_products';
    public const MAIN_TABLE = 'promotional_promo';

    public const DEFAULT_STATUS = 1;

    public const DEFAULT_SORT_ORDER = 10;

    /**
     * Get Promo Id
     * @return int
     */
    public function getPromoId();

    /**
     * Set Promo Id
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     */
    public function setPromoId($promoId);

    /**
     * Get Promo Name
     * @return string
     */
    public function getPromoName();

    /**
     * Set Promo Name
     * @param $promoName
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     */
    public function setPromoName($promoName);

    /**
     * Get Promo Type
     *
     * @return string
     */
    public function getType();

    /**
     * Set Promo Type
     *
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     */
    public function setType($promoType);

    /**
     * Get Discount Value
     *
     * @return float
     */
    public function getValue();

    /**
     * set Discount Value
     *
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     */
    public function setValue($promoValue);

    /**
     * Get Promo StartDate
     *
     * @return mixed
     */
    public function getStartDate();

    /**
     * Set Promo StartDate
     *
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     */
    public function setStartDate($promoStart);

    /**
     * Get Promo EndDate
     *
     * @return mixed
     */
    public function getEndDate();

    /**
     * Set Promo EndDate
     *
     * @return mixed
     */
    public function setEndDate($promoEnd);

    /**
     * Get Promo Status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set Promo Status
     *
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     */
    public function setStatus($promoStatus);
}