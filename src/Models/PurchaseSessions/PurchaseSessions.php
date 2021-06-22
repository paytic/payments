<?php

namespace ByTIC\Payments\Models\PurchaseSessions;

use ByTIC\Common\Records\Records;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PurchaseSessions
 * @package ByTIC\Payments\Models\PurchaseSessions
 */
class PurchaseSessions extends Records
{
    use SingletonTrait;
    use PurchaseSessionsTrait;

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}
