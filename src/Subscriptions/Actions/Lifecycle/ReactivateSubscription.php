<?php

namespace Paytic\Payments\Subscriptions\Actions\Lifecycle;

use Nip\Utility\Date;
use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;
use Paytic\Payments\Subscriptions\Actions\Charges\CalculateNextCharge;
use Paytic\Payments\Subscriptions\Events\Lifecycle\SubscriptionReactivated;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions\Lifecycle
 */
class ReactivateSubscription extends AbstractAction
{

    /**
     */
    public function handle(): void
    {
        $subscription = $this->getSubject();

        $subscription->charge_attempts = 0;
        $subscription->charge_at = Date::now()->toDateTimeString();
        CalculateNextCharge::for($subscription);
        $subscription->setStatus(SubscriptionStatusInterface::ACTIVE);
        $subscription->update();

        $this->triggerEvent(SubscriptionReactivated::class);
    }
}
