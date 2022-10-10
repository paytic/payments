<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Charges\CalculateNextCharge;
use Paytic\Payments\Subscriptions\Statuses\Active;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions
 */
class StartSubscription
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        $subscription->charge_count = 1;
        $subscription->charge_at = $subscription->start_at;
        CalculateNextCharge::for($subscription);
        $subscription->setStatus(Active::NAME);
        $subscription->update();
    }
}
