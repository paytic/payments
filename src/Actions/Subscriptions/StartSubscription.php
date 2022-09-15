<?php

namespace Paytic\Payments\Actions\Subscriptions;

use Paytic\Payments\Actions\Subscriptions\Charges\CalculateNextCharge;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Statuses\Active;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Actions\Subscriptions
 */
class StartSubscription
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        $subscription->charge_count = 1;
        CalculateNextCharge::for($subscription);
        $subscription->setStatus(Active::NAME);
        $subscription->update();
    }
}
