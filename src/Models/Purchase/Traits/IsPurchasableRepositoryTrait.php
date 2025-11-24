<?php

namespace Paytic\Payments\Models\Purchase\Traits;

use Paytic\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use Paytic\Payments\Models\Purchase\IsPurchasableRepository;
use Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethod\HasPaymentMethodRepositoryTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait IsPurchasableRepositoryTrait
 * @package Paytic\Payments\Models\Purchase\Traits
 */
trait IsPurchasableRepositoryTrait
{
    use HasCustomerRepository;
    use HasPaymentMethodRepositoryTrait;

    public function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments(): void
    {
        $this->initRelationsCustomer();
        $this->initRelationsPaymentMethod();
        $this->initRelationsPaymentTransaction();
        $this->initRelationsSessions();
    }

    public function initRelationsPaymentTransaction(): void
    {
        $this->hasOne(
            IsPurchasableRepository::RELATION_TRANSACTION,
            ['class' => get_class(PaymentsModels::transactions()), 'fk' => 'id_purchase']
        );
    }

    protected function initRelationsSessions(): void
    {
        $this->hasMany('PurchasesSessions', ['class' => get_class(PaymentsModels::sessions()), 'fk' => 'id_purchase']);
    }
}
