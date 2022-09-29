<?php

namespace Paytic\Payments\Transactions\Actions;

use Nip\Records\Record;
use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Actions\Purchases\DuplicatePurchase;
use Paytic\Payments\Models\Purchases\Purchase;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class CreateNewForSubscription
 * @package Paytic\Payments\Actions\Transactions
 */
class CreateNewTransactionInSubscription
{
    protected SubscriptionInterface $subscription;

    /**
     * @param Subscription $subscription
     */
    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @param Subscription $subscription
     * @return Transaction|TransactionTrait
     */
    public static function for(SubscriptionInterface $subscription): Record
    {
        return (new static($subscription))->execute();
    }

    protected function execute()
    {
        $purchase = $this->determinePurchase();
        $transaction = PaymentsModels::transactions()->findOrCreateForPurchase($purchase);

        $transaction->populateFromSubscription($this->subscription);
        $transaction->populateFromToken($this->subscription->getToken());
        $transaction->update();

        return $transaction;
    }

    protected function determinePurchase(): Purchase|\Nip\Records\AbstractModels\Record
    {
        $lastTransaction = $this->subscription->getLastTransaction();
        if (!is_object($lastTransaction)) {
        }
        $lastPurchase = $lastTransaction->getPurchase();

        $newPurchase = DuplicatePurchase::fromSibling($lastPurchase);
        return $newPurchase;
    }

}
