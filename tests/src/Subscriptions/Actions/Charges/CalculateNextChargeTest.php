<?php

namespace Paytic\Payments\Tests\Subscriptions\Actions\Charges;

use Paytic\CommonObjects\Subscription\Billing\BillingPeriod;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Charges\CalculateNextCharge;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class CalculateNextChargeTest
 * @package Paytic\Payments\Tests\Actions\Subscriptions\Charges
 */
class CalculateNextChargeTest extends AbstractTestCase
{
    /**
     * @dataProvider data_for
     */
    public function test_for($data, $result)
    {
        $subscription = new Subscription();
        $subscription->fill($data);

        CalculateNextCharge::for($subscription);

        self::assertEquals($result, $subscription->getPropertyRaw('charge_at'));
    }

    public function data_for(): array
    {
        return [
            [
                [
                    'start_at' => '2020-01-01',
                    'charge_at' => null,
                    'charge_count' => null,
                    'billing_period' => BillingPeriod::DAILY,
                    'billing_interval' => 1
                ],
                '2020-01-02 08:00:00',
            ],
            [
                [
                    'start_at' => '2020-01-01',
                    'charge_at' => '2020-01-01',
                    'charge_count' => null,
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2020-02-01 08:00:00',
            ],
            [
                [
                    'start_at' => '2020-01-01',
                    'charge_at' => '2020-01-01',
                    'charge_count' => 1,
                    'billing_period' => BillingPeriod::DAILY,
                    'billing_interval' => 1
                ],
                '2020-01-02 08:00:00',
            ],
            [
                [
                    'start_at' => '2020-01-01',
                    'charge_count' => 5,
                    'billing_period' => BillingPeriod::DAILY,
                    'billing_interval' => 1
                ],
                '2020-01-02 08:00:00',
            ],
            [
                [
                    'start_at' => '2020-01-01',
                    'charge_count' => 2,
                    'billing_period' => BillingPeriod::DAILY,
                    'billing_interval' => 1
                ],
                '2020-01-02 08:00:00',
            ],
            [
                [
                    'start_at' => '2020-01-01',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2020-02-01 08:00:00',
            ],
            [
                [
                    'start_at' => '2021-05-31 00:00:00',
                    'charge_count' => '',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2021-06-30 08:00:00',
            ],
            [
                [
                    'start_at' => '2021-05-30 00:00:00',
                    'charge_count' => '',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2021-06-30 08:00:00',
            ],
            [
                [
                    'start_at' => '2021-06-30 00:00:00',
                    'charge_count' => '',
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2021-07-30 08:00:00',
            ],
            [
                [
                    'start_at' => '2021-05-31 00:00:00',
                    'charge_at' => '2022-06-01 00:00:00',
                    'charge_count' => 2,
                    'billing_period' => BillingPeriod::MONTHLY,
                    'billing_interval' => 1
                ],
                '2022-07-01 08:00:00',
            ]
        ];
    }
}
