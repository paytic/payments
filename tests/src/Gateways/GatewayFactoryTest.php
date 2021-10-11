<?php

namespace ByTIC\Payments\Tests\Gateways;

use ByTIC\Payments\Gateways\GatewayFactory;
use ByTIC\Payments\Tests\AbstractTest;

/**
 * Class GatewayFactoryTest
 * @package ByTIC\Payments\Tests\Gateways
 */
class GatewayFactoryTest extends AbstractTest
{
    /**
     * @dataProvider getNameProvider
     * @param $short
     * @param $class
     */
    public function testGetGatewayClassName($short, $class)
    {
        self::assertEquals(
            $class,
            GatewayFactory::getGatewayClassName($short)
        );
    }

    /**
     * @return array
     */
    public function getNameProvider()
    {
        return [
            ['Payu', '\ByTIC\Payments\Gateways\Providers\Payu\Gateway'],
            ['Euplatesc', '\ByTIC\Payments\Gateways\Providers\Euplatesc\Gateway'],
            ['Twispay', '\ByTIC\Payments\Gateways\Providers\Twispay\Gateway'],
            ['Librapay', '\Paytic\Payments\Librapay\Gateway'],
            ['Mobilpay', '\ByTIC\Payments\Mobilpay\Gateway'],
        ];
    }
}
