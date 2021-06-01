<?php

namespace ByTIC\Payments\Actions\Subscriptions;

use ByTIC\Payments\Actions\Subscriptions\Charges\ChargedSuccessfully;
use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Models\Transactions\Statuses\Active;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Subscriptions\Statuses\{Active as SubscriptionActive, Canceled, Completed, NotStarted};

/**
 * Class UpdateFromTransactionToken
 * @package ByTIC\Payments\Actions\Subscriptions
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
            ChargedSuccessfully::handle($subscription);
            return;
        }
    }
}