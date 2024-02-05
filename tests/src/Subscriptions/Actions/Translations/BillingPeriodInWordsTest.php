<?php

namespace Paytic\Payments\Tests\Subscriptions\Actions\Translations;

use Exception;
use Paytic\CommonObjects\Subscription\Billing\BillingPeriod;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Translations\BillingPeriodInWords;
use PHPUnit\Framework\TestCase;

class BillingPeriodInWordsTest extends TestCase
{
    /**
     * @param $interval
     * @param $period
     * @param $expected
     * @return void
     * @dataProvider data_handle
     * @throws Exception
     */
    public function test_handle($interval, $period, $expected)
    {
        $subscription = new Subscription();
        $subscription->billEvery($interval, $period);

        $action = BillingPeriodInWords::for($subscription);
        self::assertSame(
            $expected,
            $action->handle()
        );
    }

    public function data_handle()
    {
        return [
            [1, BillingPeriod::DAILY, 'Zilnic'],
            [12, BillingPeriod::DAILY, 'O dată la 12 zile'],
            [1, BillingPeriod::WEEKLY, 'Săptămânal'],
            [12, BillingPeriod::WEEKLY, 'O dată la 12 săptămâni'],
            [1, BillingPeriod::MONTHLY, 'Lunar'],
            [12, BillingPeriod::MONTHLY, 'O dată la 12 luni'],
            [1, BillingPeriod::YEARLY, 'Anual'],
            [12, BillingPeriod::YEARLY, 'O dată la 12 ani'],
        ];
    }
}
