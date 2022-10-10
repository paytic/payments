<?php

namespace Paytic\Payments\Models\Subscriptions\Behaviours\HasTransactions;

use Paytic\Payments\Models\Subscriptions\SubscriptionInterface;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;

/**
 *
 */
trait HasTransactionsRecord
{

    /**
     * @param Transaction|TransactionTrait $transaction
     */
    public function populateFromLastTransaction($transaction)
    {
        $this->id_last_transaction = $transaction->id;
        $this->getRelation('LastTransaction')->setResults($transaction);
    }

    /**
     * @param Transaction|TransactionTrait $transaction
     * @return bool
     */
    public function isTransactionProcessed($transaction): bool
    {
        $processed = $this->getTransactionProcessed();
        return in_array($transaction->id, $processed);
    }

    public function getTransactionProcessed(): array
    {
        $transactionProcessed = $this->getMetadataValue(SubscriptionInterface::META_TRANSACTIONS_PROCESSED);
        return is_array($transactionProcessed) ? $transactionProcessed : [];
    }

    /**
     * @param $transaction
     * @return void
     */
    public function addTransactionProcessed($transaction): void
    {
        $processed = $this->getTransactionProcessed();
        $processed[] = $transaction->id;
        $this->setMedataValue(SubscriptionInterface::META_TRANSACTIONS_PROCESSED, $processed);
    }
}

