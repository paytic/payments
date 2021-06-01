<?php

namespace ByTIC\Payments\Actions\Subscriptions;

use ByTIC\Payments\Actions\Subscriptions\Charges\CalculateNextCharge;
use ByTIC\Payments\Models\Subscriptions\Subscription;

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
        $subscription->billing_count = 1;
        CalculateNextCharge::for($subscription);
        $subscription->update();
    }
}