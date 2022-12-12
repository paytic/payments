<?php

declare(strict_types=1);

namespace ByTIC\Payments\Tests\Subscriptions\Statuses;

use Paytic\Payments\Subscriptions\Statuses\Active;
use Paytic\Payments\Subscriptions\Statuses\Pending;
use PHPUnit\Framework\TestCase;

class ActiveTest extends TestCase
{
    public function testCompareToString()
    {
        $status = new Active();
        self::assertTrue(Active::NAME == $status);
        self::assertFalse(Pending::NAME == $status);
    }
}
