<?php

namespace ByTIC\Payments\Models\Purchase\Traits;


use ByTIC\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Trait IsPurchasableRepositoryTrait
 * @package ByTIC\Payments\Models\Purchase\Traits
 */
trait IsPurchasableRepositoryTrait
{
    use HasCustomerRepository;

    public function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments()
    {
        $this->initRelationsCustomer();
        $this->initRelationsPaymentMethod();
        $this->initRelationsSessions();
    }

    protected function initRelationsPaymentMethod()
    {
        $this->belongsTo('PaymentMethod');
    }

    protected function initRelationsSessions()
    {
        $this->hasMany('PurchasesSessions', ['class' => get_class(PaymentsModels::sessions()), 'fk' => 'id_purchase']);
    }
}
