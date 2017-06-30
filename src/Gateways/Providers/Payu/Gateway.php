<?php

namespace ByTIC\Payments\Gateways\Providers\Payu;

use ByTIC\Common\Payments\Gateways\Providers\Payu\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Payu
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;
}
