<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    public const URL_PATH_EDIT = 'promotional/promo/edit';
    public const URL_PATH_DELETE = 'promotional/promo/delete';

    /**
     * @var \Magento\Framework\UrlInterface $urlBuilder
     */
    protected $urlBuilder;

    /**
     * @inheritdoc
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);

        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {

            if (!isset($item['id'])) {
                continue;
            }

            $item[$this->getData('name')] = [
                'edit' => [
                    'href' => $this->urlBuilder->getUrl(
                        static::URL_PATH_EDIT,
                        [
                            'id' => $item['id'],
                        ]
                    ),
                    'label' => __('Edit'),
                ],
                'delete' => [
                    'href' => $this->urlBuilder->getUrl(
                        static::URL_PATH_DELETE,
                        [
                            'id' => $item['id'],
                        ]
                    ),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete "${ $.$data.name }"'),
                        'message' => __('Are you sure you wan\'t to delete the promo "${ $.$data.name }" ?'),
                    ],
                ],
            ];
        }

        return $dataSource;
    }
}