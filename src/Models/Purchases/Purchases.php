<?php

namespace ByTIC\Payments\Models\Purchases;

use ByTIC\Payments\Models\AbstractModels\AbstractRecordManager;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Purchases
 * @package ByTIC\Payments\Models\Purchases
 */
class Purchases extends AbstractRecordManager
{
    use SingletonTrait;
    use PurchasesTrait;

}
