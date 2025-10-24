<?php

namespace Paytic\Payments\Models\Purchases;

use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Purchases
 * @package Paytic\Payments\Models\Purchases
 */
class Purchases extends AbstractRecordManager
{
    public const TABLE = 'payments-purchases';
    public const CONTROLLER = 'payments-purchases';

    use PurchasesTrait;
}
