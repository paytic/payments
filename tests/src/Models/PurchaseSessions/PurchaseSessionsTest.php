<?php

namespace Paytic\Payments\Tests\Models\PurchaseSessions;

use Paytic\Payments\Models\PurchaseSessions\PurchaseSessions;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class PaymentsAssetsTest
 * @package Paytic\Payments\Tests\Utility
 */
class PurchaseSessionsTest extends AbstractTestCase
{
    public function test_getController()
    {
        $repository = new PurchaseSessions();
        self::assertSame('purchase_sessions', $repository->getController());
    }
}
