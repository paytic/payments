<?php

namespace Paytic\Payments\Tests\Subscriptions\Actions\Charges;

use DateInterval;
use Nip\Utility\Date;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargeIsDue;
use Paytic\Payments\Subscriptions\Statuses\Active;
use PHPUnit\Framework\TestCase;

class ChargeIsDueTest extends TestCase
{
    /**
     * @dataProvider data_for
     */
    public function testFor($data, $result)
    {
        $subscription = new Subscription();
        $subscription->status = Active::NAME;
        $subscription->fill($data);

        self::assertEquals($result, ChargeIsDue::for($subscription));
    }

    public function data_for(): array
    {
        $now = Date::now();
        return [
            [
                ['charge_at' => null],
                false
            ],
            [
                ['charge_at' => ''],
                false
            ],
            [
                ['charge_at' => $now->add(new DateInterval('PT1H'))->format('Y-m-d H:i:s')],
                false
            ],
            [
                ['charge_at' => '2020-01-01'],
                true
            ],
            [
                ['charge_at' => $now->sub(new DateInterval('PT1H'))->format('Y-m-d H:i:s')],
                true
            ],
        ];
    }
}
