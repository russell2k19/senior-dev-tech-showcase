<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model;

use HarveyNorman\PromotionalProducts\Api\Data\PromoInterface;
use HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface;
use HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo as ResourcePromo;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Promo Repository model
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PromoRepository implements PromoRepositoryInterface
{
    /**
     * @var ResourcePromo
     */
    protected $resource;


    /**
     * Save Promo
     *
     * @param PromoInterface $promo
     * @return mixed
     * @throws CouldNotSaveException
     */
    public function save(PromoInterface $promo)
    {
        try {
            $this->resource->save($promo);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the promo: %1',
                    $exception->getMessage()
                )
            );
        }
        return $promo;
    }

    public function getById($promoId)
    {
        // TODO: Implement getById() method.
    }

    public function delete(PromoInterface $promo)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($promoId)
    {
        // TODO: Implement deleteById() method.
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }
}