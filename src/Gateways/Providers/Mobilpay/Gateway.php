<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay;

use ByTIC\Omnipay\Mobilpay\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

//use ByTIC\Common\Payments\Gateways\Providers\Mobilpay\Gateway as AbstractGateway;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;

    /**
     * @return bool
     */
    public function isActive()
    {
        if (strlen($this->getCertificate()) >= 5 && strlen($this->getPrivateKey()) > 10) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function setSandbox($value)
    {
        return $this->setTestMode($value == 'yes');
    }

    /**
     * @inheritDoc
     */
    public function getSandbox()
    {
        return $this->getTestMode() === true ? 'yes' : 'no';
    }
}
