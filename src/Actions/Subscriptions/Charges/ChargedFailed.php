<?php

namespace ByTIC\Payments\Actions\Subscriptions\Charges;

use ByTIC\Payments\Models\Subscriptions\Subscription;

/**
 * Class ChargedFailed
 * @package ByTIC\Payments\Actions\Subscriptions\Charges
 */
class ChargedFailed
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        $subscription->charge_attempts = $subscription->charge_attempts + 1;
        CalculateNextCharge::for($subscription);
        $subscription->update();
    }
}