<?php

namespace ByTIC\Payments\Actions\Purchases;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\Purchases\Purchase;

/**
 * Class DuplicatePurchase
 * @package ByTIC\Payments\Actions\Purchases
 */
class DuplicatePurchase
{
    /**
     * @param Purchase|IsPurchasableModelTrait $purchase
     * @return Purchase
     */
    public static function fromSibling($purchase): \Nip\Records\AbstractModels\Record
    {
        $duplicate = $purchase->getClone();
        $unset = ['uuid','status'];
        foreach ($unset as $field) {
            unset($duplicate->{$field});
        }
        $duplicate->insert();
        return $duplicate;
    }
}