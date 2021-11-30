<?php

namespace ByTIC\Payments\Tests\Models\Transactions;

use ByTIC\Payments\Models\Transactions\Statuses\Active;
use ByTIC\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class TransactionsTraitTest
 * @package ByTIC\Payments\Tests\Models\Transactions
 */
class TransactionsTraitTest extends AbstractTest
{
    public function test_getStatuses()
    {
        $statuses = Transactions::instance()->getStatuses();

        self::assertCount(4, $statuses);
        self::assertInstanceOf(Active::class, $statuses['active']);
    }
}
