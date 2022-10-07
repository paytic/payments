<?php

namespace ByTIC\Payments\Tests\Subscriptions\Statuses;

use Paytic\Payments\Subscriptions\Statuses\Active;
use Paytic\Payments\Subscriptions\Statuses\Pending;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class ActiveTest extends TestCase
{
    public function test_compare_to_string()
    {
        $status = new Active();
        self::assertTrue($status == Active::NAME);
        self::assertFalse($status == Pending::NAME);
    }
}
