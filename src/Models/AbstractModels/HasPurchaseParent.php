<?php

namespace ByTIC\Payments\Models\AbstractModels;

use ByTIC\Payments\Models\Transactions\TransactionTrait;

/**
 * Trait HasPurchaseParent
 * @package ByTIC\Payments\Models\AbstractModels
 */
trait HasPurchaseParent
{
    /**
     * @param $payment
     * @return $this
     */
    public function populateFromPayment($payment)
    {
        $this->{$this->getPurchaseFk()} = $payment->id;

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