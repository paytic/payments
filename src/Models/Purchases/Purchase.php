<?php

namespace Paytic\Payments\Models\Purchases;

use Paytic\Payments\Models\AbstractModels\AbstractRecord;

/**
 * Class Purchase
 * @package Paytic\Payments\Models\Purchases
 */
class Purchase extends AbstractRecord
{
    use PurchaseTrait;

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

    public function getRegistry()
    {
        // TODO: Implement getRegistry() method.
    }
}
