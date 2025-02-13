<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Controller\Adminhtml\Promo;

use HarveyNorman\PromotionalProducts\Controller\Adminhtml\Promo;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Promo Create Action
 */
class NewAction extends Promo implements HttpGetActionInterface
{
    /**
     * New Action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}