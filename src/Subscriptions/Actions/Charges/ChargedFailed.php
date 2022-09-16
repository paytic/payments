<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class ChargedFailed
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class ChargedFailed
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        $subscription->charge_attempts = $subscription->charge_attempts + 1;
//        CalculateNextCharge::for($subscription);
        $subscription->update();
    }
}
