<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Gateways\Manager\Traits;

use Paytic\Payments\Gateways\GatewayFactory;
use Paytic\Payments\Gateways\Manager;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class HasFactoryTraitTest.
 */
class HasFactoryTraitTest extends AbstractTest
{
    public function testGetFactory()
    {
        $manager = Manager::instance();
        $factory1 = $manager->getFactory();
        self::assertInstanceOf(GatewayFactory::class, $factory1);

        $factory2 = Manager::factory();
        self::assertInstanceOf(GatewayFactory::class, $factory2);

        self::assertSame($factory1, $factory2);
    }
}
