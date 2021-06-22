<?php

namespace ByTIC\Payments\Tests\Models\Subscriptions;

use ByTIC\Payments\Models\Subscriptions\Subscriptions;
use ByTIC\Payments\Subscriptions\ChargeMethods\Gateway;
use ByTIC\Payments\Subscriptions\ChargeMethods\Internal;
use ByTIC\Payments\Subscriptions\Statuses\Active;
use ByTIC\Payments\Subscriptions\Statuses\NotStarted;
use ByTIC\Payments\Tests\AbstractTest;
use Mockery\Mock;
use Nip\Database\Query\Select;
use Nip\Records\Collections\Collection;

/**
 * Class SubscriptionsTraitTest
 * @package ByTIC\Payments\Tests\Models\Subscriptions
 */
class SubscriptionsTraitTest extends AbstractTest
{
    public function test_getStatuses()
    {
        $statuses = Subscriptions::instance()->getStatuses();

        self::assertCount(4, $statuses);

        self::assertInstanceOf(Active::class, $statuses[Active::NAME]);
        self::assertInstanceOf(NotStarted::class, $statuses[NotStarted::NAME]);
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
        $repository = \Mockery::mock(Subscriptions::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $repository->shouldReceive('findByQuery')
            ->with(\Mockery::capture($query))
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
