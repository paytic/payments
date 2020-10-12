<?php

namespace ByTIC\Payments\Gateways\Providers\Payu\Message;

use ByTIC\Omnipay\Payu\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Payu\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Omnipay\Payu\Message
 */
class CompletePurchaseRequest extends AbstractCompletePurchaseRequest
{
    use Traits\CompletePurchaseRequestTrait;

    /**
     * @inheritdoc
     */
    public function isValidNotification()
    {
        if ($this->hasGet('ctrl')) {
            if ($this->validateModel()) {
                return parent::isValidNotification();
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getModelIdFromRequest()
    {
        if ($this->httpRequest->query->has('hash')) {
            return $this->httpRequest->query->get('hash');
        }

        return $this->httpRequest->query->get('id');
    }

    /**
     * @inheritDoc
     */
    protected function parseNotification()
    {
        $model = $this->getModel();
        $this->updateParametersFromPurchase($model);

        return parent::parseNotification();
    }


    /**
     * @inheritdoc
     */
    protected function generateCtrl()
    {
        return $this->getModelCtrl();
    }

    /**
     * @return string
     */
    public function getModelCtrl()
    {
        /** @var IsPurchasableModelTrait $model */
        $model = $this->getModel();
        /** @var Gateway $gateway */
        $gateway = $model->getPaymentMethod()->getType()->getGateway();
        $purchaseRequest = $gateway->purchaseFromModel($model);

        return $purchaseRequest->getCtrl();
    }
}
