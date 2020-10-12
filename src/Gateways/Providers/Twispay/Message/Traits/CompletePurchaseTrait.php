<?php

namespace ByTIC\Payments\Gateways\Providers\Twispay\Message\Traits;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasGatewayRequestTrait;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Twispay\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait CompletePurchaseTrait
 * @package ByTIC\Payments\Gateways\Providers\Twispay\Message\Traits
 */
trait CompletePurchaseTrait
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
            $this->updateParametersFromPurchase($model);
        }
        return parent::parseNotification();
    }

    /**
     * @param Gateway $gateway
     */
    protected function updateParametersFromGateway($gateway)
    {
        $this->setApiKey($gateway->getParameter('apiKey'));
    }
}
