<?php

namespace Paytic\Payments\Models\AbstractModels;

use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait HasPurchaseParent
 * @package Paytic\Payments\Models\AbstractModels
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
        $this->amount = floor($payment->getPurchaseAmount() * 100);
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
