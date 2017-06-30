<?php

namespace ByTIC\Payments\Gateways\Providers\Twispay\Message;

use ByTIC\Omnipay\Twispay\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Omnipay\Twispay\Message
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
        if (count($return)) {
            $return['model'] = $this->getModel();
        }
        return $return;
    }

    /**
     * @return bool|mixed
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
     */
    protected function updateParametersFromModel($model)
    {
        $this->setApiKey($model->getPaymentMethod()->getType()->getGateway()->getParameter('apiKey'));
    }
}
