<?php

namespace ByTIC\Payments\Gateways\Providers\Payu;

use ByTIC\Omnipay\Payu\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Payu
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;

    /**
     * @return bool
     */
    public function isActive()
    {
        if (strlen($this->getMerchant()) > 5 && strlen($this->getSecretKey()) > 10) {
            return true;
        }

        return false;
    }
}
