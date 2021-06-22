<?php

namespace ByTIC\Payments\Actions\Subscriptions;

use ByTIC\Payments\Actions\Subscriptions\Charges\CalculateNextCharge;
use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Subscriptions\Statuses\Active;

/**
 * Class StartSubscription
 * @package ByTIC\Payments\Actions\Subscriptions
 */
class StartSubscription
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        $subscription->charge_count = 1;
        CalculateNextCharge::for($subscription);
        $subscription->setStatus(Active::NAME);
        $subscription->update();
    }
}
