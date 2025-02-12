<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace HarveyNorman\PromotionalProducts\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Module config class
 */
class Config
{
    /**#@+
     * Config constants
     *
     * @type string
     */
    private const XML_PATH_ENABLED = 'base/general/is_enabled';
    private const XML_PATH_LOG = 'base/general/log';
    /**#@- */

    /**
     * Config Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Check if module is enabled
     *
     * @param int|string|null $websiteId
     * @return bool
     */
    public function isEnabled(null|int|string $websiteId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteId
        );
    }

    /**
     * Check if log is enabled
     *
     * @param int|string|null $websiteId
     * @return bool
     */
    public function isLogEnabled(null|int|string $websiteId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_LOG,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteId
        );
    }
}
