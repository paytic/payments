<?php

namespace Paytic\Payments\Subscriptions\Actions\Lifecycle;

use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;
use Paytic\Payments\Subscriptions\Events\Lifecycle\SubscriptionMarkedUnpaid;
use Paytic\Payments\Utility\PaymentsEvents;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions
 */
class MarkUnpaidSubscription extends AbstractAction
{
    /**
     */
    public function handle(): void
    {
        $subscription = $this->getSubject();

        $subscription->charge_attempts = 0;
        $subscription->charge_at = null;
        $subscription->setStatus(SubscriptionStatusInterface::UNPAID);
        $subscription->update();

        PaymentsEvents::dispatch(SubscriptionMarkedUnpaid::class, $subscription);
    }
}
