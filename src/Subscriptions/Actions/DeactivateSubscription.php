<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions
 */
class DeactivateSubscription
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription): void
    {
        $subscription->charge_attempts = 0;
        $subscription->charge_at = null;
        $subscription->setStatus(SubscriptionStatusInterface::DEACTIVATED);
        $subscription->update();
    }
}
