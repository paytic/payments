<?php

namespace Paytic\Payments\Tests\Utility;

use Mockery;
use Paytic\Payments\Models\Purchases\Purchase;
use Paytic\Payments\Models\PurchaseSessions\PurchaseSessions;
use Paytic\Payments\Tests\AbstractTestCase;
use Paytic\Payments\Utility\PaymentsAssets;
use Nip\Records\Locator\ModelLocator;

/**
 * Class PaymentsAssetsTest
 * @package Paytic\Payments\Tests\Utility
 */
class PaymentsAssetsTest extends AbstractTestCase
{
    public function basePath()
    {
        self::assertStringEndsWith('bytic' . DIRECTORY_SEPARATOR . 'payments', PaymentsAssets::basePath());
    }

    public function test_adminPurchasesSessionsList_empty()
    {
        $purchase = Mockery::mock(Purchase::class)->makePartial();
        $purchase->shouldReceive('getPurchasesSessions')->once()->andReturn([]);

        ModelLocator::set(PurchaseSessions::class, new PurchaseSessions());

        $return = PaymentsAssets::adminPurchasesSessionsList($purchase);
        self::assertStringContainsString('dnx', $return);
    }
}
