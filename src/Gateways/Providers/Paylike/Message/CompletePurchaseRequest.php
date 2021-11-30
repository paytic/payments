<?php

namespace ByTIC\Payments\Gateways\Providers\Paylike\Message;

use Paytic\Omnipay\Paylike\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasGatewayRequestTrait;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Paylike\Gateway;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Paylike\Message
 *
 * @method CompletePurchaseResponse send
 */
class CompletePurchaseRequest extends AbstractCompletePurchaseRequest
{
    use HasModelRequest;
    use HasGatewayRequestTrait;

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
            $this->updateParametersFromPurchase($model);
        }

        return parent::parseNotification();
    }

    /**
     * @param Gateway $modelGateway
     */
    protected function updateParametersFromGateway($modelGateway)
    {
        $this->setPublicKey($modelGateway->getPublicKey());
        $this->setPrivateKey($modelGateway->getPrivateKey());
    }
}
