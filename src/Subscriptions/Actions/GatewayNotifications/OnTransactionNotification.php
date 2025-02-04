<?php

namespace Paytic\Payments\Subscriptions\Actions\GatewayNotifications;

use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedSuccessfully;
use Paytic\Payments\Subscriptions\Actions\StartSubscription;
use Paytic\Payments\Subscriptions\Statuses\Active as SubscriptionActive;
use Paytic\Payments\Subscriptions\Statuses\Canceled;
use Paytic\Payments\Subscriptions\Statuses\Deactivated;
use Paytic\Payments\Subscriptions\Statuses\Pastdue;
use Paytic\Payments\Subscriptions\Statuses\Paused;
use Paytic\Payments\Subscriptions\Statuses\Pending;
use Paytic\Payments\Subscriptions\Statuses\Unpaid;

/**
 * Class UpdateFromTransactionToken
 * @package Paytic\Payments\Subscriptions\Actions
 */
class OnTransactionNotification
{
    protected Subscription $subscription;
    protected Transaction $transaction;

    /**
     * @param Subscription $subscription
     * @param Transaction $transaction
     */
    public function __construct(SubscriptionInterface $subscription, Transaction $transaction)
    {
        $this->subscription = $subscription;
        $this->transaction = $transaction;
    }

    /**
     * @param Subscription $subscription
     * @param Transaction $transaction
     */
    public static function handle(SubscriptionInterface $subscription, $transaction): void
    {
        (new self($subscription, $transaction))
            ->execute();
    }

    public function execute(): void
    {
        if ($this->subscription->isInStatus([Canceled::NAME, Deactivated::NAME, Paused::NAME])) {
            return;
        }

        $status = $this->subscription->getStatus();
        if (empty($status) || $status == Pending::NAME) {
            $this->handleNotStarted();
            return;
        }

        if ($this->subscription->isInStatus(SubscriptionActive::NAME)) {
            $this->handleActive();
            return;
        }

        if ($this->subscription->isInStatus(Pastdue::NAME)) {
            $this->handlePastdue();
            return;
        }

        if ($this->subscription->isInStatus(Unpaid::NAME)) {
            $this->handleUnpaid();
            return;
        }
    }

    /**
     */
    protected function handleNotStarted(): void
    {
        if ($this->transaction->isStatusActive()) {
            StartSubscription::handle($this->subscription, $this->transaction);
            return;
        }
        // @todo logic for when transaction errors
    }

    /**
     */
    protected function handleActive(): void
    {
        if ($this->transaction->isStatusActive()) {
            ChargedSuccessfully::handle($this->subscription, $this->transaction);
        }
    }

    protected function handlePastdue()
    {
        if ($this->transaction->isStatusActive()) {
            ChargedSuccessfully::handle($this->subscription, $this->transaction);
        }
    }

    protected function handleUnpaid()
    {
        if ($this->transaction->isStatusActive()) {
            ChargedSuccessfully::handle($this->subscription, $this->transaction);
        }
    }
}
