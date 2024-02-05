<?php

namespace Paytic\Payments\Subscriptions\Actions\Lifecycle;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Nip\Utility\Date;
use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;
use Paytic\Payments\Subscriptions\Actions\Charges\CalculateNextCharge;
use Paytic\Payments\Subscriptions\Events\Lifecycle\SubscriptionReactivated;
use Paytic\Payments\Utility\PaymentsEvents;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions\Lifecycle
 */
class ReactivateSubscription extends Action
{
    use HasSubject;

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

        PaymentsEvents::dispatch(SubscriptionReactivated::class, $subscription);
    }
}
