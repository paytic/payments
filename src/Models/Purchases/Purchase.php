<?php

namespace ByTIC\Payments\Models\Purchases;

use ByTIC\Payments\Models\Methods\Traits\RecordTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Records\Record;

/**
 * Class Purchase
 * @package ByTIC\Payments\Models\Purchases
 */
class Purchase extends Record
{
    use IsPurchasableModelTrait;

    public function getPaymentMethod()
    {
        // TODO: Implement getPaymentMethod() method.
    }

    public function getPurchaseAmount()
    {
        // TODO: Implement getPurchaseAmount() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}
