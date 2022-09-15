<?php

namespace Paytic\Payments\Models\AbstractModels\HasCustomer;

/**
 * Trait HasCustomerRepository
 * @package Paytic\Payments\Models\AbstractModels\HasCustomer
 */
trait HasCustomerRepository
{
    public function initRelations()
    {
        parent::initRelations();
        $this->initRelationsCustomer();
    }

    protected function initRelationsCustomer()
    {
        $this->morphTo('Customer', ['morphPrefix' => 'customer']);
    }
}
