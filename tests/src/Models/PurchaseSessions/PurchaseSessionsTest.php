<?php

namespace ByTIC\Payments\Tests\Models\PurchaseSessions;

use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessions;
use ByTIC\Payments\Tests\AbstractTestCase;

/**
 * Class PaymentsAssetsTest
 * @package ByTIC\Payments\Tests\Utility
 */
class PurchaseSessionsTest extends AbstractTestCase
{
    public function test_getController()
    {
        $repository = new PurchaseSessions();
        self::assertSame('purchase_sessions', $repository->getController());
    }
}
