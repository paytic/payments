<?php

namespace Paytic\Payments\Models\Purchase;

use Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethod\HasPaymentMethodRepositoryInterface;

/**
 *
 */
interface IsPurchasableRepository extends HasPaymentMethodRepositoryInterface
{
    public const RELATION_TRANSACTION = 'PaymentTransaction';
}
