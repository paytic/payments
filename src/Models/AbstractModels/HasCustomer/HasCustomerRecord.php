<?php

namespace Paytic\Payments\Models\AbstractModels\HasCustomer;

use Nip\Records\Record;
use Paytic\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;

/**
 * Trait HasCustomerRecord
 * @package Paytic\Payments\Models\AbstractModels\HasCustomer
 *
 * @property int $customer_id
 * @property string $customer_type
 *
 * @method Record getCustomer
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
