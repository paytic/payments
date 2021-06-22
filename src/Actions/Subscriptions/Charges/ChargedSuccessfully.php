<?php

namespace ByTIC\Payments\Actions\Subscriptions\Charges;

use ByTIC\Payments\Models\Subscriptions\Subscription;

/**
 * Class ChargedSuccessfully
 * @package ByTIC\Payments\Actions\Subscriptions\Charges
 */
class ChargedSuccessfully
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        $subscription->charge_count = $subscription->charge_count + 1;
        CalculateNextCharge::for($subscription);
        $subscription->update();
    }
}
