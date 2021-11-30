<?php

namespace ByTIC\Payments\Models\Methods;

use ByTIC\Payments\Models\AbstractModels\AbstractRecord;

/**
 * Class PaymentMethod
 * @package ByTIC\Payments\Models\Methods
 */
class PaymentMethod extends AbstractRecord
{
    use Traits\RecordTrait;

    public function getPurchasesCount()
    {
        // TODO: Implement getPurchasesCount() method.
    }
}
