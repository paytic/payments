<?php

namespace Paytic\Payments\Models\Methods;

use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class PaymentMethods
 * @package Paytic\Payments\Models\Methods
 */
class PaymentMethods extends AbstractRecordManager
{
    public const TABLE = 'payments-methods';

    use Traits\RecordsTrait;
}
