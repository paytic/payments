<?php

namespace ByTIC\Payments\Models\Purchases;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait PurchaseTrait
 * @package ByTIC\Payments\Models\Purchases
 */
trait PurchaseTrait
{
    use IsPurchasableModelTrait;
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;

}