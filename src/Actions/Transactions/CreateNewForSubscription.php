<?php

namespace Paytic\Payments\Actions\Transactions;

use Nip\Records\Record;
use Paytic\Payments\Actions\Purchases\DuplicatePurchase;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class CreateNewForSubscription
 * @package Paytic\Payments\Actions\Transactions
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
