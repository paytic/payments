<?php

namespace Paytic\Payments\Models\Subscriptions\Behaviours\HasTransactions;

use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait HasTransactionsRepository
{

    protected function initRelationsTransactions(): void
    {
        $this->hasMany('Transactions', ['class' => get_class(PaymentsModels::transactions())]);
    }

    protected function initRelationsLastTransaction(): void
    {
        $this->hasOne('LastTransaction', ['class' => get_class(PaymentsModels::transactions())]);
    }
}

