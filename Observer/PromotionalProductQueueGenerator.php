<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use HarveyNorman\PromotionalProducts\Model\Backend\Publisher;
use HarveyNorman\PromotionalProducts\Helper\Data as ModuleHelper;

class PromotionalProductQueueGenerator implements ObserverInterface
{

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\Backend\Publisher
     */
    private Publisher $publisher;

    /**
     * @var \HarveyNorman\PromotionalProducts\Helper\Data
     */
    private ModuleHelper $helper;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param \HarveyNorman\PromotionalProducts\Model\Backend\Publisher $publisher
     * @param \HarveyNorman\PromotionalProducts\Helper\Data $helper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Publisher $publisher,
        ModuleHelper $helper,
        LoggerInterface $logger
    ) {
        $this->helper = $helper;
        $this->publisher = $publisher;
        $this->logger = $logger;
    }

    /**
     * Queue Promotional Product
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var  $product \Magento\Catalog\Model\Product */
        $product = $observer->getEvent()->getProduct();

        if ($this->isPromotionalStartDateProvided($product)) {
            $payload = $this->generatePayload($product);
            $this->publisher->publish($payload);
        }

        return $this;
    }

    /**
     * Check if Product is candidate for Promotional Product submission to RabbitMQ
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    protected function isPromotionalStartDateProvided($product)
    {
        $searchHaystack = ['hn_promotion_start_date'=>''];
        $arrVal = $this->helper->getAttrValByCode($product, $searchHaystack);

        return (bool)strtotime($arrVal['hn_promotion_start_date']);
    }

    /**
     * Generate Payload for queue
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    protected function generatePayload($product)
    {
        return $this->helper->parsePromotionalData($product);
    }
}
