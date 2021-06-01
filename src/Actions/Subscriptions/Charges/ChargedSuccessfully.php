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
        $subscription->billing_count = $subscription->billing_count+1;
        CalculateNextCharge::for($subscription);
        $subscription->update();
    }
}