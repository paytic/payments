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
    use GatewayTrait;
}
