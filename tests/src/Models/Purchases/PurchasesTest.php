<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Purchases;

use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class PurchasesTest.
 */
class PurchasesTest extends AbstractTestCase
{
    public function testGetController()
    {
        self::assertSame('purchases', Purchases::instance()->getController());
    }

    public function testGetStatuses()
    {
        $statuses = Purchases::instance()->getStatuses();

        self::assertCount(4, $statuses);
        self::assertInstanceOf(Active::class, $statuses['active']);
    }
}
