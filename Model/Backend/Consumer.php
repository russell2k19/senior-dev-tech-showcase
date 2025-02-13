<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Model\Backend;

use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use HarveyNorman\PromotionalProducts\Model\Config;

/**
 * Consumer class for processing discount calculation and promotion period
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Consumer
{
    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    private $serializer;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $jsonHelper;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\Config
     */
    private Config $config;

    /**
     * Consumer Constructor
     *
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonHelper
     * @param \HarveyNorman\PromotionalProducts\Model\Config $config
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        SerializerInterface $serializer,
        Json $jsonHelper,
        Config $config,
        LoggerInterface $logger
    ) {
        $this->serializer = $serializer;
        $this->jsonHelper = $jsonHelper;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Consumer Process
     *
     * @param string $message
     * @return bool
     */
    public function process(string $message)
    {
        $result = false;
        if (!$this->config->isEnabled()) {
            return false;
        }

        try {
            $this->execute($message);
            $result = true;
        } catch (\Zend_Db_Adapter_Exception $e) {
            if ($this->config->isLogEnabled()) {
                $this->logger->critical(" Promotional Product Consumer Update Error: " . $e->getMessage());
            }
        }

        return $result;
    }

    /**
     * Execute
     *
     * @param string $message
     * @return void
     */
    public function execute($message)
    {
        /** @TODO Promotional Product Consumer logic and piggy-backed indexer process for elasticsearch */
    }
}
