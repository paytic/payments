<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Librapay;

use ByTIC\Payments\Gateways\Providers\Librapay\Gateway;
use ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Librapay\LibrapayData;
use ByTIC\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;
use ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\GatewayTest as AbstractGatewayTest;

/**
 * Class GatewayTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\Librapay
 */
class GatewayTest extends AbstractGatewayTest
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

    protected function setUp()
    {
        parent::setUp();

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->purchase->getPaymentMethod();
        $paymentMethod->options = trim(LibrapayData::getMethodOptions());

        $this->purchase->created = date('Y-m-d H:i:s');

        $this->gateway = $paymentMethod->getType()->getGateway();
    }
}
