<?php

namespace ByTIC\Payments\Tests\Actions\Subscriptions\Charges;

use ByTIC\Payments\Actions\Subscriptions\Charges\CalculateNextCharge;
use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Subscriptions\Billing\BillingPeriod;

/**
 * Class CalculateNextChargeTest
 * @package ByTIC\Payments\Tests\Actions\Subscriptions\Charges
 */
class CalculateNextChargeTest extends \ByTIC\Payments\Tests\AbstractTestCase
{
    /**
     * @dataProvider data_for
     */
    public function test_for($data, $result)
    {
        $subscription = new Subscription();
        $subscription->fill($data);

        CalculateNextCharge::for($subscription);

        self::assertEquals($result, substr($subscription->getPropertyRaw('charge_at'), 0, 10));
    }

    public function data_for(): array
    {
        return [
            [
                [
                    'start_at' => '2020-01-01',
                    'charge_count' => '',
                    'billing_period' => BillingPeriod::DAILY,
                    'billing_interval' => 1
                ],
                '2020-01-02',
            ],
            [
                [
                    'start_at' => '2020-01-01',
                    'charge_count' => 4,
                    'billing_period' => BillingPeriod::DAILY,
                    'billing_interval' => 1
                ],
                '2020-01-05',
            ],
            [
                [
                    'start_at' => '2020-01-01',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2020-02-01',
            ],
            [
                [
                    'start_at' => '2021-05-31 00:00:00',
                    'charge_count' => '',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2021-06-30',
            ],
            [
                [
                    'start_at' => '2021-05-30 00:00:00',
                    'charge_count' => '',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2021-06-30',
            ],
            [
                [
                    'start_at' => '2021-06-30 00:00:00',
                    'charge_count' => '',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2021-07-30',
            ],
            [
                [
                    'start_at' => '2021-05-31 00:00:00',
                    'charge_count' => 2,
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2021-07-31',
            ]
        ];
    }
}