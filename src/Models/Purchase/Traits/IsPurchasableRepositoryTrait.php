<?php

namespace Paytic\Payments\Models\Purchase\Traits;

use Paytic\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use Paytic\Payments\Models\Purchase\IsPurchasableRepository;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait IsPurchasableRepositoryTrait
 * @package Paytic\Payments\Models\Purchase\Traits
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

    protected function initRelationsPaymentMethod(): void
    {
        $this->belongsTo(
            IsPurchasableRepository::RELATION_METHODS,
            ['class' => get_class(PaymentsModels::methods()), 'fk' => 'id_payment_method']
        );
    }

    protected function initRelationsSessions()
    {
        $this->hasMany('PurchasesSessions', ['class' => get_class(PaymentsModels::sessions()), 'fk' => 'id_purchase']);
    }
}
