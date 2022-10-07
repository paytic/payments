<?php

namespace Paytic\Payments\Subscriptions\Actions\GatewayNotifications;

use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Statuses\Active as TransactionActive;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedSuccessfully;
use Paytic\Payments\Subscriptions\Actions\StartSubscription;
use Paytic\Payments\Subscriptions\Statuses\Active as SubscriptionActive;
use Paytic\Payments\Subscriptions\Statuses\Canceled;
use Paytic\Payments\Subscriptions\Statuses\Deactivated;
use Paytic\Payments\Subscriptions\Statuses\Paused;
use Paytic\Payments\Subscriptions\Statuses\Pending;

/**
 * Class UpdateFromTransactionToken
 * @package Paytic\Payments\Subscriptions\Actions
 */
class UpdateFromTransactionNotification
{
    protected Subscription $subscription;
    protected Transaction $transaction;

    /**
     * @param Subscription $subscription
     * @param Transaction $transaction
     */
    public function __construct(Subscription $subscription, Transaction $transaction)
    {
        $this->subscription = $subscription;
        $this->transaction = $transaction;
    }

    /**
     * @param Subscription $subscription
     * @param Transaction $transaction
     */
    public static function handle($subscription, $transaction): void
    {
        (new self($subscription, $transaction))
            ->execute();
    }

    public function execute(): void
    {
        $status = $this->subscription->getStatus();

        if ($status == Canceled::NAME || $status == Deactivated::NAME || $status == Paused::NAME) {
            return;
        }

        if (empty($status) || $status == Pending::NAME) {
            $this->handleNotStarted();
            return;
        }

        if ($status == SubscriptionActive::NAME) {
            $this->handleActive();
            return;
        }
    }

    /**
     */
    protected function handleNotStarted(): void
    {
        if ($this->isTransactionActive()) {
            StartSubscription::handle($this->subscription);
            return;
        }
        // @todo logic for when transaction errors
    }

    /**
     */
    protected function handleActive(): void
    {
        if ($this->isTransactionActive()) {
            ChargedSuccessfully::handle($this->subscription);
            return;
        }
    }

    protected function isTransactionActive(): bool
    {
        return $this->transaction->getStatus() == TransactionActive::NAME;
    }
}
