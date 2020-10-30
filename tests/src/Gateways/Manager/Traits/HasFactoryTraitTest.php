<?php

namespace ByTIC\Payments\Tests\Gateways\Manager\Traits;

use ByTIC\Payments\Gateways\GatewayFactory;
use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Tests\AbstractTest;

/**
 * Class HasFactoryTraitTest
 * @package ByTIC\Payments\Tests\Gateways\Manager\Traits
 */
class HasFactoryTraitTest extends AbstractTest
{
    public function test_getFactory()
    {
        $manager = Manager::instance();
        $factory1 = $manager->getFactory();
        self::assertInstanceOf(GatewayFactory::class, $factory1);

        $factory2 = Manager::factory();
        self::assertInstanceOf(GatewayFactory::class, $factory2);

        self::assertSame($factory1, $factory2);
    }
}
