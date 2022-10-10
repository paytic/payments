<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedSuccessfully;
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
    public static function handle($subscription, $transaction)
    {
        $subscription->charge_at = $subscription->start_at;
        $subscription->setStatus(Active::NAME);
        ChargedSuccessfully::handle($subscription, $transaction);
    }
}
