<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Librapay;

use ByTIC\Payments\Gateways\Providers\Librapay\Gateway;
use ByTIC\Payments\Tests\AbstractTest;

/**
 * Class GatewayTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\Librapay
 */
class GatewayTest extends AbstractTest
{
    public function testIsActive()
    {
        $gateway = new Gateway();
        self::assertFalse($gateway->isActive());

        $gateway->setMerchant('999999');
        $gateway->setTerminal('999999');
        $gateway->setKey('999999');
        $gateway->setMerchantName('999999');
        $gateway->setMerchantEmail('999999');

        self::assertFalse($gateway->isActive());

        $gateway->setMerchantUrl('9');

        self::assertFalse($gateway->isActive());

        $gateway->setMerchantUrl('999999');

        self::assertTrue($gateway->isActive());
    }
}
