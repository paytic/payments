<?php

namespace Paytic\Payments\Models\Transactions;

use Paytic\Payments\Models\AbstractModels\AbstractRecord;

/**
 * Class Transaction
 * @package Paytic\Payments\Models\Transactions
 */
class Transaction extends AbstractRecord
{
    use TransactionTrait;
}
