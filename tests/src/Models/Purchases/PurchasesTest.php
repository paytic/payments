<?php

namespace Paytic\Payments\Tests\Models\Purchases;

use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class PurchasesTest
 * @package Paytic\Payments\Tests\Models\Purchases
 */
class PurchasesTest extends AbstractTestCase
{
    public function test_getController()
    {
        self::assertSame('purchases', Purchases::instance()->getController());
    }

    public function test_getStatuses()
    {
        $statuses = Purchases::instance()->getStatuses();

        self::assertCount(4, $statuses);
        self::assertInstanceOf(Active::class, $statuses['active']);
    }
}
