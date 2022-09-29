<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Paytic\CommonObjects\Subscription\SubscriptionInterface;
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
    public static function handle(SubscriptionInterface $subscription)
    {
        $subscription->charge_count = $subscription->charge_count + 1;
        $subscription->charge_attempts = 0;
        CalculateNextCharge::for($subscription);
        $subscription->update();
    }
}
