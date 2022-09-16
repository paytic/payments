<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Exception;
use Nip\Records\Record;
use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedFailed;
use Paytic\Payments\Transactions\Actions\ChargeWithToken;
use Paytic\Payments\Transactions\Actions\CreateNewTransactionInSubscription;

/**
 * Class ChargeSubscription
 * @package Paytic\Payments\Subscriptions\Actions
 */
class ChargeSubscription
{
    protected SubscriptionInterface $subscription;

    /**
     * @param SubscriptionInterface $subscription
     */
    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        (new self($subscription))->execute();
    }

    public function execute()
    {
        $this->subscription->guardIsChargeable();

        $transaction = $this->determineTransaction();
        $this->chargeTransaction($transaction);
    }

    protected function determineTransaction(): Transaction|Record
    {
        if ($this->subscription->charge_attempts > 0) {
            return $this->subscription->getLastTransaction();
        }

        return CreateNewTransactionInSubscription::for($this->subscription);
    }

    protected function chargeTransaction($transaction)
    {
        try {
            ChargeWithToken::process($transaction);
        } catch (Exception $exception) {
            ChargedFailed::handle($this->subscription);
        }
    }
}
