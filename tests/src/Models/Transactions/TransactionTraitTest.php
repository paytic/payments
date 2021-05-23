<?php

namespace ByTIC\Payments\Tests\Models\Transactions;

use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Tests\AbstractTest;

/**
 * Class TransactionTraitTest
 * @package ByTIC\Payments\Tests\Models\Transactions
 */
class TransactionTraitTest extends AbstractTest
{
    public function test_cast_metadata()
    {
        $item = new Transaction();

        $metadata = $item->metadata;
        self::assertInstanceOf(\ArrayObject::class, $metadata);

        $item->addMedata('test', 99);
        self::assertSame(99, $item->metadata['test']);

        self::assertSame('{"test":99}', $item->getPropertyRaw('metadata'));
    }
}