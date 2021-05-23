<?php

namespace ByTIC\Payments\Models\Transactions;

use ByTIC\Common\Records\Records;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Transactions
 * @package ByTIC\Payments\Models\Transactions
 */
class Transactions extends Records
{
    public const TABLE = 'payments-transactions';

    use SingletonTrait;
    use TransactionsTrait;

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}