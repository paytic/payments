<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Transactions;

use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class TransactionsTraitTest.
 */
class TransactionsTraitTest extends AbstractTest
{
    public function testGetStatuses()
    {
        $repository = new Transactions();
        $statuses = $repository->getStatuses();

        self::assertCount(4, $statuses);
        self::assertInstanceOf(Active::class, $statuses['active']);
    }
}
