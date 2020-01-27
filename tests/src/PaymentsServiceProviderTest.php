<?php

namespace ByTIC\Payments\Tests;

use ByTIC\Payments\PaymentsServiceProvider;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecordManager;
use Nip\Container\Container;

/**
 * Class PaymentsServiceProviderTest
 * @package ByTIC\Payments\Tests
 */
class PaymentsServiceProviderTest extends AbstractTest
{
    public function testRegister()
    {
        $provider = new PaymentsServiceProvider();
        $provider->setContainer(Container::getInstance());
        $provider::setPurchaseModel(PurchasableRecordManager::class);
        $provider->register();

        $purchases = $provider->getContainer()->get('purchases');
        self::assertInstanceOf(PurchasableRecordManager::class, $purchases);
    }
}
