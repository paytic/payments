<?php

namespace ByTIC\Payments\Models\Methods;

use ByTIC\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class PaymentMethods
 * @package ByTIC\Payments\Models\Methods
 */
class PaymentMethods extends AbstractRecordManager
{
    public const TABLE = 'payments-methods';

    use Traits\RecordsTrait;
}
