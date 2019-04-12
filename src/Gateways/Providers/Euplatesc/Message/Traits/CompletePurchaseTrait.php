<?php

namespace ByTIC\Payments\Gateways\Providers\Euplatesc\Message\Traits;

use ByTIC\Payments\Gateways\Providers\Euplatesc\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait CompletePurchaseTrait
 * @package ByTIC\Payments\Gateways\Providers\Euplatesc\Message\Traits
 */
trait CompletePurchaseTrait
{
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

    /**
     * @param IsPurchasableModelTrait $model
     */
    protected function updateParametersFromModel($model)
    {
        /** @var Gateway $gateway */
        $gateway = $model->getPaymentMethod()->getType()->getGateway();
        $this->setMid($gateway->getMid());
        $this->setKey($gateway->getKey());
    }
}
