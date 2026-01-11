<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\PurchaseSessions;

use Paytic\Payments\PurchaseSessions\Models\PurchaseSessions;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class PaymentsAssetsTest.
 */
class PurchaseSessionsTest extends AbstractTestCase
{
    public function testGetController()
    {
        $repository = new PurchaseSessions();
        self::assertSame('purchase_sessions', $repository->getController());
    }
}
