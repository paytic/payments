<?php

namespace Paytic\Payments\Models\Methods;

use Paytic\Payments\Models\AbstractModels\AbstractRecord;
use Paytic\Payments\PaymentMethods\Models\PaymentMethodInterface;

/**
 * Class PaymentMethod
 * @package Paytic\Payments\Models\Methods
 */
class PaymentMethod extends AbstractRecord implements PaymentMethodInterface
{
    use Traits\RecordTrait;

    public function getPurchasesCount()
    {
        // TODO: Implement getPurchasesCount() method.
    }

}
