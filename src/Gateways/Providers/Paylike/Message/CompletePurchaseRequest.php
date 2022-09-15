<?php

namespace Paytic\Payments\Gateways\Providers\Paylike\Message;

use Exception;
use Paytic\Omnipay\Paylike\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasGatewayRequestTrait;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use Paytic\Payments\Gateways\Providers\Paylike\Gateway;

/**
 * Class PurchaseResponse
 * @package Paytic\Payments\Gateways\Providers\Paylike\Message
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
     * @throws Exception
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
