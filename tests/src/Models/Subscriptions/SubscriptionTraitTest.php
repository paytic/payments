<?php

namespace ByTIC\Payments\Tests\Models\Subscriptions;

use ByTIC\Payments\Models\Methods\PaymentMethods;
use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Models\Subscriptions\Subscriptions;
use ByTIC\Payments\Models\Tokens\Token;
use ByTIC\Payments\Models\Tokens\Tokens;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\Transactions;
use ByTIC\Payments\Subscriptions\ChargeMethods\Gateway;
use ByTIC\Payments\Subscriptions\ChargeMethods\Internal;
use ByTIC\Payments\Tests\AbstractTest;
use Nip\Database\Query\Insert;
use Nip\Records\Locator\ModelLocator;

/**
 * Class SubscriptionTraitTest
 * @package ByTIC\Payments\Tests\Models\Subscriptions
 */
class SubscriptionTraitTest extends AbstractTest
{

    /**
     * @dataProvider data_getChargeMethod
     */
    public function test_getChargeMethod($value, $class)
    {
        $repository = Subscriptions::instance();

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

    public function test_populateFromToken()
    {
        ModelLocator::set(Tokens::class, Tokens::instance());
        ModelLocator::set(PaymentMethods::class, PaymentMethods::instance());

        $repository = \Mockery::mock(Subscriptions::class)->shouldAllowMockingProtectedMethods()->makePartial();
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
