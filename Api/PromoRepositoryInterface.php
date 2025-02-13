<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Api;

use HarveyNorman\PromotionalProducts\Api\Data\PromoInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Promo Repository Interface
 */
interface PromoRepositoryInterface
{
    /**
     * Save Promo
     *
     * @param \HarveyNorman\PromotionalProducts\Api\Data\PromoInterface $promo
     *
     * @return mixed
     */
    public function save(PromoInterface $promo);

    /**
     * Get Promo by Id
     *
     * @param string $promoId
     * @return mixed
     */
    public function getById($promoId);

    /**
     * Delete Promo
     *
     * @param PromoInterface $promo
     * @return mixed
     */
    public function delete(PromoInterface $promo);

    /**
     * Delete Promo by ID
     *
     * @param int $promoId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($promoId);

    /**
     * Retrieve Promo matching the specified criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \HarveyNorman\PromotionalProducts\Api\Data\PromoSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}