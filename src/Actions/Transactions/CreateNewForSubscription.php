<?php

namespace ByTIC\Payments\Actions\Transactions;

use ByTIC\Payments\Actions\Purchases\DuplicatePurchase;
use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\TransactionTrait;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\Record;

/**
 * Class CreateNewForSubscription
 * @package ByTIC\Payments\Actions\Transactions
 */
class CreateNewForSubscription
{
    /**
     * @param Subscription $subscription
     * @return Transaction|TransactionTrait
     */
    public static function handle($subscription): Record
    {
        $lastTransaction = $subscription->getLastTransaction();
        if (!is_object($lastTransaction)) {
        }
        $lastPurchase = $lastTransaction->getPurchase();

        $newPurchase = DuplicatePurchase::fromSibling($lastPurchase);
        $transaction = PaymentsModels::transactions()->findOrCreateForPurchase($newPurchase);

        $transaction->populateFromSubscription($subscription);
        $transaction->populateFromToken($subscription->getToken());
        $transaction->update();

        return $transaction;
    }
}
