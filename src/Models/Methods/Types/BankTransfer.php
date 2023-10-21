<?php

namespace Paytic\Payments\Models\Methods\Types;

/**
 * Class BankTransfer
 * @package Paytic\Payments\Models\Methods\Types
 */
class BankTransfer extends AbstractType
{
    public const NAME = 'bank_transfer';

    protected $aliases = ['bank-transfer','bank_transfer'];
}
