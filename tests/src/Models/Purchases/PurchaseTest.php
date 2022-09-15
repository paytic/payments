<?php

namespace Paytic\Payments\Tests\Models\Purchases;

use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class PurchasesTest
 * @package Paytic\Payments\Tests\Models\Purchases
 */
class PurchaseTest extends AbstractTestCase
{
    public function test_getController()
    {
        self::assertSame('purchases', Purchases::instance()->getController());
    }
}
