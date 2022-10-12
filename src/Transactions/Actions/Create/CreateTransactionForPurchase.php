<?php

namespace Paytic\Payments\Transactions\Actions\Create;

use Nip\Records\AbstractModels\Record;
use Paytic\Payments\Exception\InvalidArgumentException;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableTrait;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class CreateTransactionForPurchase
{
    const EXCEPTION_INVALID_METHOD = 'Purchase has no valid Payment Method';
    /**
     * @var IsPurchasableModelTrait
     */
    protected $purchase;

    /**
     * @var Transaction
     */
    protected $transaction;

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
    public function execute()
    {
        $this->transaction = $this->createTransaction();
        $this->populatePaymentMethod();
        $this->saveTransaction();
        return $this->transaction;
    }

    /**
     * @return Record|TransactionTrait
     */
    protected function createTransaction()
    {
        $transaction = $this->transactionRepository->getNew();
        $transaction->populateFromPayment($this->purchase);
        $transaction->status = (string)$this->purchase->status;

        return $transaction;
    }

    protected function populatePaymentMethod()
    {
        $paymentMethod = $this->purchase->getPaymentMethod();
        if (false == is_object($paymentMethod)) {
            throw new InvalidArgumentException(self::EXCEPTION_INVALID_METHOD);
        }

        $this->transaction->populateFromPaymentMethod($paymentMethod);
        $this->transaction->populateFromGateway($paymentMethod->getType()->getGateway());
    }

    protected function saveTransaction()
    {
        $this->transaction->insert();
    }

}
