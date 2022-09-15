<?php

namespace Paytic\Payments\Gateways\Providers\Romcard\Message;

use Paytic\Omnipay\Romcard\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasGatewayRequestTrait;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use Paytic\Payments\Gateways\Providers\Romcard\Message\Traits\CompletePurchaseTrait;

/**
 * Class PurchaseResponse
 * @package Paytic\Payments\Gateways\Providers\Romcard\Message
 */
class CompletePurchaseRequest extends AbstractCompletePurchaseRequest
{
    use HasModelRequest;
    use CompletePurchaseTrait;
    use HasGatewayRequestTrait;

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
     * @return string
     */
    public function getModelIdFromRequest()
    {
        $modelId = $this->getHttpRequestBag()->get('ORDER');

        return $modelId;
    }

    /**
     * @inheritdoc
     */
    protected function parseNotification()
    {
        if ($this->validateModel()) {
            $model = $this->getModel();
            $this->updateParametersFromPurchase($model);
        }

        return parent::parseNotification();
    }
}
