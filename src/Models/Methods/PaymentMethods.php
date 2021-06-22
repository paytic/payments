<?php

namespace ByTIC\Payments\Models\Methods;

use ByTIC\Common\Records\Records;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PaymentMethods
 * @package ByTIC\Payments\Models\Methods
 */
class PaymentMethods extends Records
{
    public const TABLE = 'payments-methods';

    use Traits\RecordsTrait;
    use SingletonTrait;

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}
