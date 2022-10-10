<?php

namespace Paytic\Payments\Transactions\Actions\Create;

use Nip\Records\AbstractModels\Record;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableTrait;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class CreateTransactionForPurchase
{
    protected $purchase;

    protected $transactionRepository;

    /**
     * @param $purchase
     */
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
        $this->transactionRepository = PaymentsModels::transactions();
    }

    /**
     * @param IsPurchasableTrait $purchase
     * @return Record|TransactionTrait|Transaction
     */
    public static function for($purchase)
    {
        return (new static($purchase))->execute();
    }

    /**
     * @return Record|TransactionTrait|Transaction
     */
    protected function execute()
    {
        $transaction = $this->transactionRepository->getNew();
        $transaction->populateFromPayment($this->purchase);

        $paymentMethod = $this->purchase->getPaymentMethod();
        $transaction->populateFromPaymentMethod($paymentMethod);
        $transaction->populateFromGateway($paymentMethod->getType()->getGateway());
        $transaction->insert();
        return $transaction;
    }
}
