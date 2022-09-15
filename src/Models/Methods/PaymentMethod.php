<?php

namespace Paytic\Payments\Models\Methods;

use Paytic\Payments\Models\AbstractModels\AbstractRecord;

/**
 * Class PaymentMethod
 * @package Paytic\Payments\Models\Methods
 */
class PaymentMethod extends AbstractRecord
{
    use Traits\RecordTrait;

    public function getPurchasesCount()
    {
        // TODO: Implement getPurchasesCount() method.
    }
}
