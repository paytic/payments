<?php

namespace Paytic\Payments\Models\AbstractModels\HasTenant;

/**
 * Trait HasTenantRepository
 * @package Paytic\Payments\Models\AbstractModels\HasTenant
 */
trait HasTenantRepository
{
    public function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments(): void
    {
        $this->initRelationsPaymentsTenant();
    }

    protected function initRelationsPaymentsTenant(): void
    {
        $this->morphTo('Tenant', ['morphPrefix' => 'tenant', 'morphTypeField' => 'tenant']);
    }
}
