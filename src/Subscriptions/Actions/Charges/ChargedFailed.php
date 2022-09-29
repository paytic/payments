<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\DeactivateSubscription;

/**
 * Class ChargedFailed
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class ChargedFailed
{
    /**
     * @param Subscription|SubscriptionInterface $subscription
     */
    public static function handle(SubscriptionInterface $subscription)
    {
        if ($subscription->isChargeAttemptsMaxed()) {
            DeactivateSubscription::handle($subscription);
            return;
        }

        $subscription->charge_attempts = $subscription->charge_attempts + 1;
        CalculateNextAttempt::for($subscription);
        $subscription->update();
    }
}
