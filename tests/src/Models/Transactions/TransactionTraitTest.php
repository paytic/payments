<?php

namespace ByTIC\Payments\Tests\Models\Transactions;

use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Tests\AbstractTest;
use Nip\Database\Query\Insert;

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

    public function test_cast_metadata_empty()
    {
        $repository = \Mockery::mock(Transactions::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $repository->shouldReceive('insertQuery')->once()->andReturn(new Insert());
        $repository->shouldReceive('performInsert')->once();
        $repository->bootTransactionsTrait();

        $item = new Transaction();
        $item->setManager($repository);
        $item->insert();

        self::assertSame('{}', $item->getPropertyRaw('metadata'));
    }
}
