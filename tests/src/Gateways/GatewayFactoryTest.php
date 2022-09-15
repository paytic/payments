<?php

namespace Paytic\Payments\Tests\Gateways;

use Paytic\Payments\Gateways\GatewayFactory;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class GatewayFactoryTest
 * @package Paytic\Payments\Tests\Gateways
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
            ['Payu', '\Paytic\Payments\Payu\Gateway'],
            ['Euplatesc', '\Paytic\Payments\Euplatesc\Gateway'],
            ['Twispay', '\Paytic\Payments\Twispay\Gateway'],
            ['Librapay', '\Paytic\Payments\Librapay\Gateway'],
            ['Mobilpay', '\Paytic\Payments\Mobilpay\Gateway'],
        ];
    }
}
