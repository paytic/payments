<?php

namespace ByTIC\Payments\Models\Transactions;

use ByTIC\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Transactions
 * @package ByTIC\Payments\Models\Transactions
 */
class Transactions extends AbstractRecordManager
{
    public const TABLE = 'payments-transactions';

    use TransactionsTrait;
}
