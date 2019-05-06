<?php

namespace ByTIC\Payments\Gateways\Providers\Romcard\Message;

use ByTIC\Omnipay\Romcard\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Romcard\Helper;
use ByTIC\Payments\Gateways\Providers\Romcard\Message\Traits\CompletePurchaseTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Romcard\Message
 */
class CompletePurchaseRequest extends AbstractCompletePurchaseRequest
{
    use HasModelRequest;
    use CompletePurchaseTrait;

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
            $this->updateParametersFromModel($model);
        }

        return parent::parseNotification();
    }
}
