<?php

namespace Paytic\Payments\Models\AbstractModels\HasGateway;

use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait as AbstractGateway;

/**
 * Trait HasGatewayRecordTrait
 * @package Paytic\Payments\Models\AbstractModels\HasGateway
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
