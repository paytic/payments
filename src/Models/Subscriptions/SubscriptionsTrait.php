<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;

/**
 * Trait SubscriptionsTrait
 * @package ByTIC\Payments\Models\Subscriptions
 *
 * @method SubscriptionTrait|Subscription getNew
 */
trait SubscriptionsTrait
{
    use HasCustomerRepository;

    /**
     * @return mixed|\Nip\Config\Config
     * @throws \Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.subscriptions', Subscriptions::TABLE);
    }
}
