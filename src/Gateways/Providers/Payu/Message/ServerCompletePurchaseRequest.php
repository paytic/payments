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
    use HasModelRequest;

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $return = parent::getData();
        // Add model only if has data
        if (count($return)) {
            $return['model'] = $this->getModel();
        }

        return $return;
    }

    /**
     * @inheritdoc
     */
    protected function isValidNotification()
    {
        if ($this->hasPOST('REFNOEXT')) {
            if ($this->validateModel()) {
                $model = $this->getModel();
                $this->updateParametersFromModel($model);

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

    /**
     * @param IsPurchasableModelTrait $model
     */
    protected function updateParametersFromModel($model)
    {
        /** @var Gateway $gateway */
        $gateway = $model->getPaymentMethod()->getType()->getGateway();
//        $this->setMerchant($gateway->getMerchant());
        $this->setSecretKey($gateway->getSecretKey());
    }
}
