<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Promo Search results model Innterface
 */
interface PromoSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Promo Items
     *
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface
     */
    public function getItems();

    /**
     * Set Promo Items
     *
     * @param array $items
     * @return PromoSearchResultsIterface
     */
    public function setItems(array $items);
}