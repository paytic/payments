<?php

namespace Paytic\Payments\Actions\Purchases;

use Nip\Records\AbstractModels\Record;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\Purchases\Purchase;

/**
 * Class DuplicatePurchase
 * @package Paytic\Payments\Actions\Purchases
 */
class DuplicatePurchase
{
    /**
     * @param Purchase|IsPurchasableModelTrait $purchase
     * @return Purchase
     */
    public static function fromSibling($purchase, $extra = []): Record
    {
        $duplicate = $purchase->getClone();
        $unset = ['uuid', 'status'];
        foreach ($unset as $field) {
            unset($duplicate->{$field});
        }
        $duplicate->fill($extra);
        $duplicate->insert();
        return $duplicate;
    }
}
