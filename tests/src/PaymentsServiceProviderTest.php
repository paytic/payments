<?php

namespace ByTIC\Payments\Tests;

use ByTIC\Payments\PaymentsServiceProvider;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecordManager;

class PaymentsServiceProviderTest extends AbstractTest
{
    public function testRegister()
    {
        $provider = new PaymentsServiceProvider();
        $provider::setPurchaseModel(PurchasableRecordManager::class);
        $provider->register();

        $purchases = $provider->getContainer()->get('purchases');
        self::assertInstanceOf(PurchasableRecordManager::class, $purchases);
    }
}
