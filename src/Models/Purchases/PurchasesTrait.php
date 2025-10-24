<?php

namespace Paytic\Payments\Models\Purchases;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;
use Nip\Config\Config;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableRepositoryTrait;
use Paytic\Payments\Models\Transactions\Statuses\Pending;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait PurchasesTrait
 * @package Paytic\Payments\Models\Purchases
 */
trait PurchasesTrait
{
    use IsPurchasableRepositoryTrait;
    use RecordsTrait;

    /**
     * @return string
     */
    public function getStatusItemsRootNamespace()
    {
        return '\Paytic\Payments\Models\Transactions\Statuses\\';
    }

    /**
     * @return string
     */
    public function getStatusItemsDirectory()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Transactions' . DIRECTORY_SEPARATOR . 'Statuses';
    }

    public function getDefaultStatus(): string
    {
        return Pending::NAME;
    }

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.' . PaymentsModels::PURCHASES, Purchases::TABLE);
    }
}
