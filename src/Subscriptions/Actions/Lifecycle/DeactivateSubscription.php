<?php

namespace Paytic\Payments\Subscriptions\Actions\Lifecycle;

use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions\Lifecycle
 */
class DeactivateSubscription extends AbstractAction
{
    /**
     */
    public function handle(): void
    {
        $subscription = $this->getSubject();

        $subscription->charge_attempts = 0;
        $subscription->charge_at = null;
        $subscription->setStatus(SubscriptionStatusInterface::DEACTIVATED);
        $subscription->update();
    }
}
