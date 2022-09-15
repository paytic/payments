<?php

namespace Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits;

use Omnipay\Common\AbstractGateway;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait HasGatewayParamsRequestTrait
 * @package Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits
 */
trait HasGatewayRequestTrait
{
    /**
     * @param IsPurchasableModelTrait $model
     */
    protected function updateParametersFromPurchase($model)
    {
        /** @var AbstractGateway $gateway */
        $gateway = $model->getPaymentMethod()->getType()->getGateway();

        if ($gateway) {
            $this->updateParametersFromGateway($gateway);
        }
    }

    /**
     * @param AbstractGateway $gateway
     * @return void
     */
    abstract protected function updateParametersFromGateway($gateway);
}
