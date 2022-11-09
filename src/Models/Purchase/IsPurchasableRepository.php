<?php

namespace Paytic\Payments\Models\Purchase;

/**
 *
 */
interface IsPurchasableRepository
{
    public const RELATION_METHODS = 'PaymentMethod';
    public const RELATION_TRANSACTION = 'PaymentTransaction';
}
