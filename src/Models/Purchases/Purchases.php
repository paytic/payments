<?php

namespace ByTIC\Payments\Models\Purchases;

use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Purchases
 * @package ByTIC\Payments\Models\Purchases
 */
class Purchases extends RecordManager
{
    use SingletonTrait;
    use PurchasesTrait;

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}
