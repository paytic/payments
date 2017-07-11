<?php

namespace ByTIC\Payments\Gateways\Providers\Twispay;

use ByTIC\Omnipay\Twispay\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Twispay
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait {
        GatewayTrait::setSandbox as abstractSetSandbox;
    }

    /**
     * @inheritdoc
     */
    public function setSandbox($value)
    {
        $return = $this->abstractSetSandbox($value);
        $this->parameters->remove('secureUrl');
        return $return;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        if (intval($this->getSiteId()) >= 5 && strlen($this->getPrivateKey()) > 10) {
            return true;
        }

        return false;
    }
}
