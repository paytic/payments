<?php

namespace Paytic\Payments\Subscriptions\Actions\Lifecycle;

use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Events\Lifecycle\SubscriptionMarkedUnpaid;
use Paytic\Payments\Utility\PaymentsEvents;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions
 */
class MarkUnpaidSubscription
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription): void
    {
        $subscription->charge_attempts = 0;
        $subscription->charge_at = null;
        $subscription->setStatus(SubscriptionStatusInterface::UNPAID);
        $subscription->update();

        PaymentsEvents::dispatch(SubscriptionMarkedUnpaid::class, $subscription);
    }
}
