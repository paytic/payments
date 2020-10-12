<?php

namespace ByTIC\Payments\Gateways\Providers\Romcard\Message\Traits;

use ByTIC\Payments\Gateways\Providers\Romcard\Gateway;

/**
 * Trait CompletePurchaseTrait
 */
trait CompletePurchaseTrait
{
    /**
     * @param Gateway $gateway
     */
    protected function updateParametersFromGateway($gateway)
    {
        $this->setTerminal($gateway->getTerminal());
        $this->setKey($gateway->getKey());
        $this->setMerchantName($gateway->getMerchantName());
        $this->setMerchantEmail($gateway->getMerchantEmail());
        $this->setMerchantUrl($gateway->getMerchantUrl());
    }
}
