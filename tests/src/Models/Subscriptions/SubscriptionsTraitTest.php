<?php

namespace Paytic\Payments\Tests\Models\Subscriptions;

use Mockery;
use Mockery\Mock;
use Nip\Database\Query\Select;
use Nip\Records\Collections\Collection;
use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Subscriptions\ChargeMethods\Gateway;
use Paytic\Payments\Subscriptions\ChargeMethods\Internal;
use Paytic\Payments\Subscriptions\Statuses\Active;
use Paytic\Payments\Subscriptions\Statuses\Paused;
use Paytic\Payments\Subscriptions\Statuses\Pending;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class SubscriptionsTraitTest
 * @package Paytic\Payments\Tests\Models\Subscriptions
 */
class SubscriptionsTraitTest extends AbstractTest
{
    public function test_getStatuses()
    {
        $statuses = Subscriptions::instance()->getStatuses();

        self::assertCount(5, $statuses);

        self::assertInstanceOf(Active::class, $statuses[Active::NAME]);
        self::assertInstanceOf(Pending::class, $statuses[Pending::NAME]);
        self::assertInstanceOf(Paused::class, $statuses[Paused::NAME]);
    }

    public function test_getChargeMethods()
    {
        $repository = Subscriptions::instance();

        $methods = $repository->getChargeMethods();

        self::assertCount(2, $methods);
        self::assertInstanceOf(Internal::class, $methods['internal']);
        self::assertInstanceOf(Gateway::class, $methods['gateway']);
    }

    public function test_findChargeDue()
    {
        /** @var Mock|Subscriptions $repository */
        $repository = Mockery::mock(Subscriptions::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $repository->shouldReceive('findByQuery')
            ->with(Mockery::capture($query))
            ->andReturn(new Collection());

        $repository->findChargeDue(10);

        self::assertInstanceOf(Select::class, $query);
        self::assertSame(
            'SELECT `payments-subscriptions`.* '
            . 'FROM `payments-subscriptions` '
            . 'WHERE charge_at IS NOT NULL AND charge_at < NOW() '
            . 'ORDER BY `charge_at` ASC LIMIT 10',
            (string)$query
        );
    }
}
