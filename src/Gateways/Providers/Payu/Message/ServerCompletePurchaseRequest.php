<?php

namespace ByTIC\Payments\Gateways\Providers\Payu\Message;

use ByTIC\Omnipay\Payu\Message\ServerCompletePurchaseRequest as AbstractServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Payu\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class ServerCompletePurchaseRequest
 * @package ByTIC\Omnipay\Payu\Message
 */
class ServerCompletePurchaseRequest extends AbstractServerCompletePurchaseRequest
{
    use Traits\CompletePurchaseRequestTrait;

    /**
     * @inheritdoc
     */
    public function isValidNotification()
    {
        if ($this->hasPOST('REFNOEXT')) {
            if ($this->validateModel()) {
                $model = $this->getModel();
                $this->updateParametersFromPurchase($model);

                return parent::isValidNotification();
            }
        }

        return false;
    }

    /**
     * Returns ID if it has it
     * @return int
     */
    public function getModelIdFromRequest()
    {
        return $this->httpRequest->request->get('REFNOEXT');
    }

}
