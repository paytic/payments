<?php

namespace Paytic\Payments\Subscriptions\Actions\Lifecycle;

use Nip\Utility\Date;
use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Events\Lifecycle\SubscriptionCanceled;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions\Lifecycle
 */
class CancelSubscription extends AbstractAction
{
    /**
     * @param Subscription $subscription
     */
    public function handle(): void
    {
        $subscription = $this->getSubject();

        $subscription->charge_attempts = 0;
        $subscription->charge_at = null;
        $subscription->cancel_at = Date::now()->toDateTimeString();
        $subscription->setStatus(SubscriptionStatusInterface::CANCELED);
        $subscription->update();

        $this->triggerEvent(SubscriptionCanceled::class);
    }
}
