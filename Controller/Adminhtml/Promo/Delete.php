<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Controller\Adminhtml\Promo;

use HarveyNorman\PromotionalProducts\Controller\Adminhtml\Promo;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Promo implements HttpGetActionInterface
{
    /**
     * Delete promo action
     *
     * @return void
     */
    public function execute()
    {
        $promoId = $this->getRequest()->getParam('id');
        if ($promoId) {
            try {
                /** @var \HarveyNorman\PromotionalProducts\Model\Promo $model */
                $model = $this->_promoFactory->create();
                $model->load($promoId);
                $title = $model->getPromoName();
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Promo "%name" deleted successfully.', ['name' => $title]));
                $this->_redirect('promotional/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete Promo right now. Please review the log and try again.')
                );
            }
        }
    }
}