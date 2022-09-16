<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class ChargedSuccessfully
 * @package Paytic\Payments\Subscriptions\Actions\Charges
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
