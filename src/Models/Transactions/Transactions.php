<?php

namespace Paytic\Payments\Models\Transactions;

use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Transactions
 * @package Paytic\Payments\Models\Transactions
 */
class Transactions extends AbstractRecordManager
{
    public const TABLE = 'payments-transactions';

    use TransactionsTrait;
}
