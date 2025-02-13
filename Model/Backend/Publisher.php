<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\Backend;

use Magento\Framework\MessageQueue\PublisherInterface;
use HarveyNorman\PromotionalProducts\Model\Config;
use Psr\Log\LoggerInterface;

/**
 * Publisher class for queueing of candidate promotional products
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Publisher
{
    /**#@+
     * Publisher Constants
     *
     * @type string
     */
    private const TOPIC_NAME = "promotional.product.update";
    /**#@- */

    /**
     * @var \Magento\Framework\MessageQueue\PublisherInterface
     */
    private PublisherInterface $publisher;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\Config
     */
    private Config $config;

    /**
     * Publisher Construct
     *
     * @param \Magento\Framework\MessageQueue\PublisherInterface $publisher
     * @param \HarveyNorman\PromotionalProducts\Model\Config $config
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        PublisherInterface $publisher,
        Config $config,
        LoggerInterface $logger
    ) {
        $this->publisher = $publisher;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Publisher publish
     *
     * @param string $message
     * @return bool
     */
    public function publish($message)
    {
        $result = false;
        if (!$this->config->isEnabled()) {
            return false;
        }

        try {
            $this->publisher->publish(self::TOPIC_NAME, $message);
            $result = true;
        } catch (\InvalidArgumentException $e) {
            if ($this->config->isLogEnabled()) {
                $this->logger->critical(" Promotional Product Publisher Error: " . $e->getMessage());
            }
        }

        return $result;
    }
}
