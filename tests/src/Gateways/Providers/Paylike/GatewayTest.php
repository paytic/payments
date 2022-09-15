<?php

namespace Paytic\Payments\Tests\Gateways\Providers\Paylike;

use Paytic\Payments\Gateways\Providers\Paylike\Gateway;

use Paytic\Payments\Tests\AbstractTest as AbstractGatewayTest;

//use Paytic\Payments\Tests\Gateways\Providers\AbstractGateway\GatewayTest as AbstractGatewayTest;

/**
 * Class GatewayTest
 * @package Paytic\Payments\Tests\Gateways\Providers\Paylike
 */
class GatewayTest extends AbstractGatewayTest
{
    public function testIsActive()
    {
        $gateway = new Gateway();
        self::assertFalse($gateway->isActive());

        $gateway->setPublicKey('99');
        $gateway->setPrivateKey('99');

        self::assertFalse($gateway->isActive());

        $gatewayParams= [
            'public_key' => '99999999',
            'private_key' => '99999999'
        ];
        $gateway->initialize($gatewayParams);

        self::assertTrue($gateway->isActive());
    }
}
