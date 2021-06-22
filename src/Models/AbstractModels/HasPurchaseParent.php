<?php

namespace ByTIC\Payments\Models\AbstractModels;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\Transactions\TransactionTrait;

/**
 * Trait HasPurchaseParent
 * @package ByTIC\Payments\Models\AbstractModels
 */
trait HasPurchaseParent
{
    /**
     * @param IsPurchasableModelTrait $payment
     * @return $this
     */
    public function populateFromPayment($payment)
    {
        $this->{$this->getPurchaseFk()} = $payment->id;
        $this->currency = $payment->getPurchaseCurrency();

        return $this;
    }

    /**
     * @return string
     */
    protected function getPurchaseFk()
    {
        return 'id_purchase';
    }
}
