<?php

namespace Paytic\Payments\Transactions\Actions;

use Nip\Records\Record;
use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Actions\Purchases\DuplicatePurchase;
use Paytic\Payments\Exception\InvalidArgumentException;
use Paytic\Payments\Models\Purchases\Purchase;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Transactions\SourceTypes\TokenCard;
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
    protected function execute(): Record
    {
        $purchase = $this->determinePurchase();
        $transaction = PaymentsModels::transactions()->findOrCreateForPurchase($purchase);

        $transaction->populateFromSubscription($this->subscription);
        $transaction->populateFromToken($this->subscription->getToken());
        $transaction->setSourceType(TokenCard::NAME);
        $transaction->update();

        $this->subscription->id_last_transaction = $transaction->id;
        $this->subscription->saveRecord();

        return $transaction;
    }

    protected function determinePurchase(): Purchase|\Nip\Records\AbstractModels\Record
    {
        $lastTransaction = $this->subscription->getLastTransaction();
        if (!is_object($lastTransaction)) {
            throw new InvalidArgumentException("Subscription has not last transaction");
        }
        $lastPurchase = $lastTransaction->getPurchase();

        $newPurchase = DuplicatePurchase::fromSibling($lastPurchase, ['status' => 'pending']);
        return $newPurchase;
    }
}
