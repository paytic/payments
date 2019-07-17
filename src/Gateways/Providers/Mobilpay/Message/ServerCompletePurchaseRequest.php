<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay\Message;

use ByTIC\Omnipay\Mobilpay\Message\ServerCompletePurchaseRequest as AbstractServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Mobilpay\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class ServerCompletePurchaseRequest
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay\Message
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
     * @return bool|mixed
     * @throws \Exception
     */
    protected function parseNotification()
    {
        if ($this->validateModel()) {
            $model = $this->getModel();
            $this->updateParametersFromModel($model);
        }

        return parent::parseNotification();
    }

    /**
     * @param IsPurchasableModelTrait $model
     *
     * @throws \Exception
     */
    protected function updateParametersFromModel($model)
    {
        /** @var Gateway $modelGateway */
        $modelGateway = $model->getPaymentMethod()->getType()->getGateway();
        $this->setSignature($modelGateway->getSignature());
        $this->setCertificate($modelGateway->getCertificate());
        $this->setPrivateKey($modelGateway->getPrivateKey());
    }
}
