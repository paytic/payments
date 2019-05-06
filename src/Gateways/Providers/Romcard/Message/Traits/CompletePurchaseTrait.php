<?php

namespace ByTIC\Payments\Gateways\Providers\Romcard\Message\Traits;

use ByTIC\Payments\Gateways\Providers\Romcard\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait CompletePurchaseTrait
 */
trait CompletePurchaseTrait
{
    /**
     * @param IsPurchasableModelTrait $model
     */
    protected function updateParametersFromModel($model)
    {
        /** @var Gateway $gateway */
        $gateway = $model->getPaymentGateway();
        if ($gateway) {
            $this->setTerminal($gateway->getTerminal());
            $this->setKey($gateway->getKey());
            $this->setMerchantName($gateway->getMerchantName());
            $this->setMerchantEmail($gateway->getMerchantEmail());
            $this->setMerchantUrl($gateway->getMerchantUrl());
        }
    }
}
