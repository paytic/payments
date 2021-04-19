<?php

namespace ByTIC\Payments\Models\Purchase\Traits;


use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Trait IsPurchasableRepositoryTrait
 * @package ByTIC\Payments\Models\Purchase\Traits
 */
trait IsPurchasableRepositoryTrait
{
    public function initRelationsPaymentMethod()
    {
        $this->belongsTo('PaymentMethod');
    }

    public function initRelationsSessions()
    {
        $this->hasMany('PurchasesSessions', ['class' => get_class(PaymentsModels::purchases()), 'fk' => 'id_purchase']);
    }
}
