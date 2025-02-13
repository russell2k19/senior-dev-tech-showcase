<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\Promo\Source;

use Magento\Framework\Data\OptionSourceInterface;
use HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Promo implements OptionSourceInterface
{
    /**
     * @var \HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface
     */
    private $promoRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param \HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface $promoRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PromoRepositoryInterface $promoRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->promoRepository = $promoRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get Option array for Promos
     *
     * @return array|void
     */
    public function toOptionArray()
    {
        $promos = $this->promoRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $options = [['value' => 0, 'label' => __('Select Promo...')]];
        foreach ($promos as $promo) {
            $options[] = ['value' => $promo->getId(), 'label' => $promo->getPromoName()];
        }

        return $options;
    }
}