<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\DeactivateSubscription;

/**
 * Class ChargedFailed
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class ChargedFailed extends AbstractChargeWithTransaction
{
    /**
     * @param Subscription|SubscriptionInterface $subscription
     */
    public function execute()
    {
        if ($this->subscription->isChargeAttemptsMaxed()) {
            DeactivateSubscription::handle($this->subscription);
            return;
        }

        $this->subscription->charge_attempts = $this->subscription->charge_attempts + 1;
        $this->calculateNextAttempt();
        $this->subscription->update();
    }
}
