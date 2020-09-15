<?php

namespace ByTIC\Payments\Gateways\Providers\Paylike\Message;

use ByTIC\Omnipay\Paylike\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Paylike\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Paylike\Message
 *
 * @method CompletePurchaseResponse send
 */
class CompletePurchaseRequest extends AbstractCompletePurchaseRequest
{
    use HasModelRequest;

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $return = parent::getData();
        // Add model only if has data
        if (count($return) && $this->validateModel()) {
            $return['model'] = $this->getModel();
        }

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function getModelIdFromRequest()
    {
        $modelId = $this->httpRequest->query->get('pOrderId');

        return $modelId;
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
        $this->setPublicKey($modelGateway->getPublicKey());
        $this->setPrivateKey($modelGateway->getPrivateKey());
    }
}
