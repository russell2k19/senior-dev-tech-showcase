<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Controller\Adminhtml\Promo;

use HarveyNorman\PromotionalProducts\Controller\Adminhtml\Promo;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Promo implements HttpGetActionInterface
{
    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $promoId = $this->getRequest()->getParam('id');

        if ($promoId) {
            try {
                $model = $this->_promoRepository->getById($promoId);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This Promo no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $this->_coreRegistry->register('promotional_promo', $model);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend($promoId ? __('Edit Promo') : __('New Promo'));

        return $resultPage;
    }
}
