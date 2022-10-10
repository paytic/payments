<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;

/**
 *
 */
abstract class AbstractChargeWithTransaction
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
     * @param SubscriptionInterface $subscription
     * @param $transaction
     * @return mixed
     */
    public static function handle(SubscriptionInterface $subscription, $transaction)
    {
        return (new static($subscription, $transaction))
            ->execute();
    }

    public abstract function execute();

    public function calculateNextAttempt(): void
    {
        CalculateNextAttempt::for($this->subscription);
    }

    protected function calculateNextCharge(): void
    {
        CalculateNextCharge::for($this->subscription);
    }
}