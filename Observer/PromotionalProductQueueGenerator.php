<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;
use HarveyNorman\PromotionalProducts\Model\Backend\Publisher;

class PromotionalProductQueueGenerator implements ObserverInterface
{
    /**
     * @var TimezoneInterface
     */
    private $localeDate;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Publisher
     */
    private Publisher $publisher;

    /**
     * @param TimezoneInterface $localeDate
     * @param \HarveyNorman\PromotionalProducts\Model\Backend\Publisher $publisher
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        TimezoneInterface $localeDate,
        Publisher $publisher,
        LoggerInterface $logger
    ) {
        $this->localeDate = $localeDate;
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
        $this->logger->info(__METHOD__ . '::' . __LINE__);
        /** @var  $product \Magento\Catalog\Model\Product */
        $product = $observer->getEvent()->getProduct();

        if ($this->isPromotionalStartDateProvided($product)) {
            $this->logger->info(__METHOD__ . '::' . __LINE__);
            $payload = $this->generatePayload($product);
            $this->publisher->publish($payload);
        }

        return $this;
    }

    /**
     * Parse Promotional Data
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    protected function parsePromotionalData($product)
    {
        $data = 'dummy data';
        /** @TODO Parse Promotional data from product */

        return $data;
    }

    /**
     * Check if Product is candidate for Promotional Product submission to RabbitMQ
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    protected function isPromotionalStartDateProvided($product)
    {
        /** @TODO logic to check if hn_promotional_start_date is atleast provided */

        return true;
    }

    /**
     * Generate Payload for queue
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    protected function generatePayload($product)
    {
        $formattedPayload = $this->parsePromotionalData($product);
        /** @TODO generate serialized Promotional Product data here */

        return $formattedPayload;
    }
}
