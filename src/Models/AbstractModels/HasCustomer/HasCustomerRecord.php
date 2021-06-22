<?php

namespace ByTIC\Payments\Models\AbstractModels\HasCustomer;

use Nip\Records\Record;
use ByTIC\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;

/**
 * Trait HasCustomerRecord
 * @package ByTIC\Payments\Models\AbstractModels\HasCustomer
 *
 * @property int $customer_id
 * @property string $customer_type
 */
trait HasCustomerRecord
{
    /**
     * @param BillingRecord|Record $customer
     */
    public function populateFromCustomer($customer)
    {
        $this->customer_id = $customer->id;
        $this->customer_type = $customer->getManager()->getMorphName();
    }
}
