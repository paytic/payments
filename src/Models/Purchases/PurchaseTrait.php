<?php

namespace Paytic\Payments\Models\Purchases;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait PurchaseTrait
 * @package Paytic\Payments\Models\Purchases
 */
trait PurchaseTrait
{
    use IsPurchasableModelTrait;
    use RecordTrait;
}
