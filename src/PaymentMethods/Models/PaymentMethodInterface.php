<?php

namespace Paytic\Payments\PaymentMethods\Models;

/**
 *
 */
interface PaymentMethodInterface
{
    public function getPaymentMethodId(): int;
}