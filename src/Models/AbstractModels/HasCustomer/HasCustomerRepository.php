<?php

namespace ByTIC\Payments\Models\AbstractModels\HasCustomer;

/**
 * Trait HasCustomerRepository
 * @package ByTIC\Payments\Models\AbstractModels\HasCustomer
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
