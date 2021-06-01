<?php

namespace ByTIC\Payments\Tests\Models\Purchases;

use ByTIC\Payments\Models\Purchases\Purchases;
use ByTIC\Payments\Tests\AbstractTestCase;

/**
 * Class PurchasesTest
 * @package ByTIC\Payments\Tests\Models\Purchases
 */
class PurchaseTest extends AbstractTestCase
{
    public function test_getController()
    {
        self::assertSame('purchases', Purchases::instance()->getController());
    }
}
