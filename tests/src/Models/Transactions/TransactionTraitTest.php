<?php

namespace Paytic\Payments\Tests\Models\Transactions;

use ArrayObject;
use Mockery;
use Nip\Database\Query\Insert;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class TransactionTraitTest
 * @package Paytic\Payments\Tests\Models\Transactions
 */
class TransactionTraitTest extends AbstractTest
{
    public function test_cast_metadata()
    {
        $item = new Transaction();

        $metadata = $item->metadata;
        self::assertInstanceOf(ArrayObject::class, $metadata);

        $item->addMedataValue('test', 99);
        self::assertSame(99, $item->metadata['test']);

        self::assertSame('{"test":99}', $item->getPropertyRaw('metadata'));
    }

    public function test_cast_metadata_empty()
    {
        $repository = Mockery::mock(Transactions::class)
            ->makePartial();
        $repository->shouldAllowMockingProtectedMethods()
        $repository->shouldReceive('insertQuery')->once()->andReturn(new Insert());
        $repository->shouldReceive('performInsert')->once();
        $repository->bootTransactionsTrait();

        $item = new Transaction();
        $item->setManager($repository);
        $item->insert();

        self::assertSame('{}', $item->getPropertyRaw('metadata'));
    }
}
