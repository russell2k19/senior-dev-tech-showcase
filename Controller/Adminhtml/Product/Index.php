<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace HarveyNorman\PromotionalProducts\Controller\Adminhtml\Product;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Controller\Adminhtml\Product\Builder;
use Magento\Framework\View\Result\PageFactory;

/**
 * Admin grid list controller
 */
class Index extends \Magento\Catalog\Controller\Adminhtml\Product implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Builder $productBuilder,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $productBuilder);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Product list page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('HarveyNorman_PromotionalProducts::promotional_products');
        $resultPage->getConfig()->getTitle()->prepend(__('Promotional Products'));
        return $resultPage;
    }
}
