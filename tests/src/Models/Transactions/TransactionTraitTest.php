<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Transactions;

use ArrayObject;
use Mockery;
use Nip\Database\Query\Insert;
use Paytic\Payments\Models\Transactions\Statuses\Error;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class TransactionTraitTest.
 */
class TransactionTraitTest extends AbstractTest
{
    public function testCastMetadata()
    {
        $item = new Transaction();

        $metadata = $item->metadata;
        self::assertInstanceOf(ArrayObject::class, $metadata);

        $item->setMedataValue('test', 99);
        self::assertSame(99, $item->metadata['test']);

        self::assertSame('{"test":99}', $item->getPropertyRaw('metadata'));
    }

    public function testCastMetadataEmpty()
    {
        $repository = Mockery::mock(Transactions::class)
            ->makePartial();
        $repository->shouldAllowMockingProtectedMethods();
        $repository->shouldReceive('insertQuery')->once()->andReturn(new Insert());
        $repository->shouldReceive('performInsert')->once();
        $repository->bootTransactionsTrait();

        $item = new Transaction();
        $item->setManager($repository);
        $item->insert();

        self::assertSame('{}', $item->getPropertyRaw('metadata'));
    }

    public function testGetStatusMessageGetterSetter()
    {
        $transaction = new Transaction();
        self::assertNull($transaction->getStatusMessage());
        self::assertNull($transaction->status_message);

        $transaction->setStatusMessage('test');
        self::assertSame('test', $transaction->getStatusMessage());

        $transaction->status_message = 'test2';
        self::assertSame('test2', $transaction->getStatusMessage());
    }

    public function test_isStatusActive()
    {
        $repository = Mockery::mock(Transactions::class)
            ->makePartial();
        $repository->shouldAllowMockingProtectedMethods();

        $transaction = new Transaction();
        $transaction->setManager($repository);
        $transaction->status = 'active';
        self::assertTrue($transaction->isStatusActive());

        $transaction->status = Error::NAME;
        self::assertFalse($transaction->isStatusActive());

        $transaction->status = 'active';
        self::assertTrue($transaction->isStatusActive());
    }
}
