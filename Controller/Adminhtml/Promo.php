<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;

/**
 * Promo abstract Action
 */
abstract class Promo extends Action
{
    /**
     * @var \HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface
     */
    protected $_promoRepository;

    /**
     * @var \HarveyNorman\PromotionalProducts\Model\PromoFactory
     */
    protected $_promoFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\Registry $coreRegistry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    private ResultFactory $_resultFactory;

    /**
     * Promo Constructor
     *
     * @param \HarveyNorman\PromotionalProducts\Api\PromoRepositoryInterface $promoRepository
     * @param \HarveyNorman\PromotionalProducts\Model\PromoFactory $promoFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param Context $context
     */
    public function __construct(
        PromoRepositoryInterface $promoRepository,
        PromoFactory $promoFactory,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        Context $context
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultFactory = $context->getResultFactory();
        $this->_promoFactory = $promoFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_promoRepository = $promoRepository;
        parent::__construct($context);
    }
}
