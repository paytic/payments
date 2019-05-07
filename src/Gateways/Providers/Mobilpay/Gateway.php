<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay;

use ByTIC\Common\Payments\Gateways\Providers\Mobilpay\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;

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
