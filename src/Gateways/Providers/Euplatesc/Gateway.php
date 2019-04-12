<?php

namespace ByTIC\Payments\Gateways\Providers\Euplatesc;

use ByTIC\Omnipay\Euplatesc\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Euplatesc
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;
}
