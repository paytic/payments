<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedSuccessfully;
use Paytic\Payments\Subscriptions\Statuses\Active as SubscriptionActive;
use Paytic\Payments\Subscriptions\Statuses\Canceled;
use Paytic\Payments\Subscriptions\Statuses\Deactivated;
use Paytic\Payments\Subscriptions\Statuses\Pending;

/**
 * Class UpdateFromTransactionToken
 * @package Paytic\Payments\Subscriptions\Actions
 */
class UpdateFromTransactionNotification
{
    /**
     * @param Subscription $subscription
     * @param Transaction $transaction
     */
    public static function handle($subscription, $transaction)
    {
        $status = $subscription->getStatus();

        if ($status instanceof Canceled || $status instanceof Deactivated) {
            return;
        }

        if ($status instanceof Pending) {
            static::handleNotStarted($subscription, $transaction);
            return;
        }

        if ($status instanceof SubscriptionActive) {
            static::handleActive($subscription, $transaction);
            return;
        }
    }

    /**
     * @param Subscription $subscription
     * @param Transaction $transaction
     */
    protected static function handleNotStarted($subscription, $transaction)
    {
        if ($transaction->getStatus() instanceof Active) {
            StartSubscription::handle($subscription);
            return;
        }
        // @todo logic for when transaction errors
    }

    /**
     * @param Subscription $subscription
     * @param Transaction $transaction
     */
    protected static function handleActive($subscription, $transaction)
    {
        if ($transaction->getStatus() instanceof Active) {
            ChargedSuccessfully::handle($subscription);
            return;
        }
    }
}
