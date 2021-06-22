<?php

namespace ByTIC\Payments\Models\AbstractModels\HasGateway;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait as AbstractGateway;

/**
 * Trait HasGatewayRecordTrait
 * @package ByTIC\Payments\Models\AbstractModels\HasGateway
 *
 * @property string $gateway
 */
trait HasGatewayRecordTrait
{
    /**
     * @param AbstractGateway $gateway
     */
    public function populateFromGateway($gateway)
    {
        $this->gateway = $gateway->getName();
    }
}
