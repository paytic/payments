<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Utility;

use Mockery;
use Nip\Records\Locator\ModelLocator;
use Paytic\Payments\Models\Purchases\Purchase;
use Paytic\Payments\PurchaseSessions\Models\PurchaseSessions;
use Paytic\Payments\Tests\AbstractTestCase;
use Paytic\Payments\Utility\PaymentsAssets;
use const DIRECTORY_SEPARATOR;

/**
 * Class PaymentsAssetsTest.
 */
class PaymentsAssetsTest extends AbstractTestCase
{
    public function basePath()
    {
        self::assertStringEndsWith('bytic' . DIRECTORY_SEPARATOR . 'payments', PaymentsAssets::basePath());
    }

    public function testAdminPurchasesSessionsListEmpty()
    {
        $purchase = Mockery::mock(Purchase::class)->makePartial();
        $purchase->shouldReceive('getPurchasesSessions')->once()->andReturn([]);

        ModelLocator::set(PurchaseSessions::class, new PurchaseSessions());

        $return = PaymentsAssets::adminPurchasesSessionsList($purchase);
        self::assertStringContainsString('dnx', $return);
    }
}
