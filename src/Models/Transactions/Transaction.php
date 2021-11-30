<?php

namespace ByTIC\Payments\Models\Transactions;

use ByTIC\Payments\Models\AbstractModels\AbstractRecord;

/**
 * Class Transaction
 * @package ByTIC\Payments\Models\Transactions
 */
class Transaction extends AbstractRecord
{
    use TransactionTrait;
}
