<?php

namespace Paytic\Payments\Models\AbstractModels\HasTenant;

use Nip\Records\Record;
use Paytic\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;

/**
 * Trait HasTenantRecord
 * @package Paytic\Payments\Models\AbstractModels\HasTenant
 *
 * @property int $tenant_id
 * @property string $tenant
 *
 * @method Record getTenant
 */
trait HasTenantRecord
{
    /**
     * @param BillingRecord|Record $record
     */
    public function populateFromTenant($record)
    {
        $this->tenant_id = $record->id;
        $this->tenant = $record->getManager()->getMorphName();
    }
}
