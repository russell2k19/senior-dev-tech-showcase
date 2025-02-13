<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\Promo;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

/**
 * Promo data provider model
 *
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.LongVariable)
 * @since 101.0.0
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $status;

    /**
     * Promo Dataprovider Costructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \HarveyNorman\PromotionalProducts\Model\ResourceModel\Promo\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $status
     * @param array $meta
     * @param array $data
     * @SuppressWarnings(PHPMD.LongVariable)
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Status $status,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->status = $status;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $promo) {
            /**
             * @var $promo \HarveyNorman\PromotionalProducts\Model\Promo
             * @var $promoProduct \Magento\Catalog\Model\Product
             */
            $this->loadedData[$promo->getId()] = $promo->getData();

            foreach ($promo->getPromoProducts() as $promoProduct) {
                $this->loadedData[$promo->getId()]['promo_product'][] = $this->fillData($promoProduct);
            }
        }
        return parent::getData();
    }

    /**
     * Prepare data column
     *
     * @param \Magento\Catalog\Model\Product $linkedProduct
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function fillData($linkedProduct)
    {
        return [
            'id' => $linkedProduct->getId(),
            'name' => $linkedProduct->getName(),
            'status' => $this->status->getOptionText($linkedProduct->getStatus()),
            'sku' => $linkedProduct->getSku(),
            'price' => $linkedProduct->getPrice()
        ];
    }
}
