<?php

namespace Paytic\Payments\Models\Purchases;

use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Purchases
 * @package Paytic\Payments\Models\Purchases
 */
class Purchases extends AbstractRecordManager
{
    use SingletonTrait;
    use PurchasesTrait;
}
