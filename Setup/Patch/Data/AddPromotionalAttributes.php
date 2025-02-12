<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Setup\Patch\Data;

use Magento\Catalog\Model\Product\Type;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;

class AddPromotionalAttributes implements DataPatchInterface
{
    /**#@+
     * Promotional Product Attribute Constants
     *
     * @type string
     */
    private const PROMOTIONAL_PRODUCT_ATTRIBUTES = [
        'hn_promotion_id' => 'Promotion ID',
        'hn_promotion_name' => 'Promotion Name',
        'hn_promotion_type' => 'Promotion type',
        'hn_promotion_value' => 'Promotion Value',
        'hn_promotion_start_date' => 'Promotion Start Date',
        'hn_promotion_end_date' => 'Promotion End Date'
    ];
    /**#@- */

    /**
     * Constructor
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly EavSetupFactory $eavSetupFactory
    ) {
    }

    /**
     * Apply Data Patch
     *
     * @return AddPromotionalAttributes|void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Validator\ValidateException
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        foreach (self::PROMOTIONAL_PRODUCT_ATTRIBUTES as $code => $label) {

            $dataType = strpos($code, 'date') ? 'datetime' : 'text';
            $baseData = [
                'label' => $label,
                'type' => $dataType,
                'input' => $dataType,
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'user_defined' => true,
                'visible_on_front' => true,
                'apply_to' => implode(',', [Type::TYPE_SIMPLE, Type::TYPE_BUNDLE]),
                'group' => 'General',
                'used_in_product_listing' => true,
                'is_used_in_grid' => true,
                'searchable' => false
            ];

            $eavSetup->addAttribute(
                Product::ENTITY,
                $code,
                $baseData
            );
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        foreach (self::PROMOTIONAL_PRODUCT_ATTRIBUTES as $code) {
            $eavSetup->removeAttribute(Product::ENTITY, $code);
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}
