<?php

namespace Paytic\Payments\Actions\Subscriptions;

use Paytic\Payments\Actions\Subscriptions\Charges\ChargedSuccessfully;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Statuses\Active as SubscriptionActive;
use Paytic\Payments\Subscriptions\Statuses\Canceled;
use Paytic\Payments\Subscriptions\Statuses\Completed;
use Paytic\Payments\Subscriptions\Statuses\NotStarted;

/**
 * Class UpdateFromTransactionToken
 * @package Paytic\Payments\Actions\Subscriptions
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

        if ($status instanceof Canceled || $status instanceof Completed) {
            return;
        }

        if ($status instanceof NotStarted) {
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
//            ChargedSuccessfully::handle($subscription);
            return;
        }
    }
}
