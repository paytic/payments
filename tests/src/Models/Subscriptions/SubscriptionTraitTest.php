<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Subscriptions;

use ByTIC\DataObjects\Casts\Metadata\Metadata;
use Mockery;
use Nip\Database\Query\Insert;
use Nip\Records\Locator\ModelLocator;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Models\Tokens\Tokens;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Subscriptions\ChargeMethods\Gateway;
use Paytic\Payments\Subscriptions\ChargeMethods\Internal;
use Paytic\Payments\Subscriptions\Statuses\Active;
use Paytic\Payments\Subscriptions\Statuses\Canceled;
use Paytic\Payments\Subscriptions\Statuses\Deactivated;
use Paytic\Payments\Subscriptions\Statuses\Paused;
use Paytic\Payments\Subscriptions\Statuses\Pending;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class SubscriptionTraitTest.
 */
class SubscriptionTraitTest extends AbstractTest
{

    /**
     * @dataProvider data_getStatusObject
     * @return void
     */
    public function test_getStatusObject($status, $class)
    {
        $item = new Subscription();
        $item->setManager(new Subscriptions());

        $item->fill(['status' => $status]);

        self::assertEquals($status, $item->getStatus());
        self::assertInstanceOf($class, $item->getStatusObject());
    }

    public function data_getStatusObject(): array
    {
        return [
            [null, Pending::class],
            ['', Pending::class],
            [Canceled::NAME, Canceled::class],
            [Deactivated::NAME, Deactivated::class],
            [Paused::NAME, Paused::class],
            [Pending::NAME, Pending::class],
            [Active::NAME, Active::class],
        ];
    }

    public function testFillData()
    {
        $item = new Subscription();
        $data = [
            'billing_interval' => '1',
            'billing_period' => 'month',
        ];
        $item->fill($data);

        self::assertSame(1, $item->billing_interval);
        self::assertSame('month', $item->billing_period);
    }

    /**
     * @dataProvider data_getChargeMethod
     */
    public function testGetChargeMethod($value, $class)
    {
        $repository = new Subscriptions();

        $item = new Subscription();
        $item->fill(['charge_method' => $value]);
        $item->setManager($repository);

        self::assertInstanceOf($class, $item->getChargeMethod());
    }

    public function data_getChargeMethod(): array
    {
        return [
            ['', Internal::class],
            [Internal::NAME, Internal::class],
            [Gateway::NAME, Gateway::class],
        ];
    }

    public function testPopulateFromToken()
    {
        ModelLocator::set(Tokens::class, new Tokens());
        ModelLocator::set(PaymentMethods::class, new PaymentMethods());

        $repository = Mockery::mock(Subscriptions::class)
            ->makePartial();
        $repository->shouldAllowMockingProtectedMethods();
        $repository->shouldReceive('initRelationsTransactions');
        $repository->shouldReceive('initRelationsLastTransaction');
        $repository->setPrimaryKey('id');

        $item = new Subscription();
        $item->setManager($repository);

        $token = new Token();
        $token->id = 7;
        $item->populateFromToken($token);

        self::assertSame(7, $item->getPropertyRaw('id_token'));
        self::assertSame($token, $item->getToken());
    }

    public function testCastMetadata()
    {
        $item = new Subscription();

        $metadata = $item->metadata;
        self::assertInstanceOf(Metadata::class, $metadata);

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
}
