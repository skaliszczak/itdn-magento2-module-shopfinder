<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace ITDN\Shopfinder\Controller\Adminhtml\Shopfinder;

use Exception;
use ITDN\Shopfinder\Model\Shopfinder;
use ITDN\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory as ShopfinderCollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    /** @var DataPersistorInterface  */
    protected $dataPersistor;

    /** @var ShopfinderCollectionFactory  */
    protected ShopfinderCollectionFactory $shopfinderCollectionFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ShopfinderCollectionFactory $shopfinderCollectionFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ShopfinderCollectionFactory $shopfinderCollectionFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->shopfinderCollectionFactory = $shopfinderCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('shopfinder_id');

            $model = $this->_objectManager->create(Shopfinder::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Shopfinder no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $this->validateUnique($model);
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Shopfinder.'));
                $this->dataPersistor->clear('itdn_shopfinder_shopfinder');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Shopfinder.'));
            }

            $this->dataPersistor->set('itdn_shopfinder_shopfinder', $data);
            return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $this->getRequest()->getParam('shopfinder_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Validate unique
     *
     * @param Shopfinder $shop
     * @return mixed
     * @throws LocalizedException
     */
    protected function validateUnique(Shopfinder $shop)
    {
        $collection = $this->shopfinderCollectionFactory->create();

        $shopfinderExisting = $collection
            ->addFieldToFilter('country', $shop->getCountry())
            ->addFieldToFilter('identifier', $shop->getIdentifier())
            ->getFirstItem();

        if ($shopfinderExisting?->getId()) {
            throw new LocalizedException(
                __("Shop with country '%1' and identifier '%2' already exist with id #%3.",
                    $shopfinderExisting->getCountry(),
                    $shopfinderExisting->getIdentifier(),
                    $shopfinderExisting->getId()
                )
            );
        }
    }
}

