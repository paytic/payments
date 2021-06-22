<?php

namespace ByTIC\Payments\Models\Purchases;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableRepositoryTrait;
use ByTIC\Payments\Models\Transactions\Transactions;

/**
 * Trait PurchasesTrait
 * @package ByTIC\Payments\Models\Purchases
 */
trait PurchasesTrait
{
    use IsPurchasableRepositoryTrait;
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;

    /**
     * @return string
     */
    public function getStatusItemsRootNamespace()
    {
        return '\ByTIC\Payments\Models\Transactions\Statuses\\';
    }

    /**
     * @return string
     */
    public function getStatusItemsDirectory()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Transactions' . DIRECTORY_SEPARATOR . 'Statuses';
    }
}
