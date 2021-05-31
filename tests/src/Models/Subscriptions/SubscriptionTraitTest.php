<?php

namespace ByTIC\Payments\Tests\Models\Subscriptions;

use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Models\Subscriptions\Subscriptions;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\Transactions;
use ByTIC\Payments\Subscriptions\Statuses\Active;
use ByTIC\Payments\Subscriptions\Statuses\NotStarted;
use ByTIC\Payments\Tests\AbstractTest;
use Nip\Database\Query\Insert;

/**
 * Class SubscriptionTraitTest
 * @package ByTIC\Payments\Tests\Models\Subscriptions
 */
class SubscriptionTraitTest extends AbstractTest
{

    public function testGetStatuses()
    {
        $statuses = Subscriptions::instance()->getStatuses();

        self::assertCount(4, $statuses);

        self::assertInstanceOf(Active::class, $statuses[Active::NAME]);
        self::assertInstanceOf(NotStarted::class, $statuses[NotStarted::NAME]);
    }

    public function test_cast_metadata()
    {
        $item = new Subscription();

        $metadata = $item->metadata;
        self::assertInstanceOf(\ByTIC\DataObjects\Casts\Metadata\Metadata::class, $metadata);

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