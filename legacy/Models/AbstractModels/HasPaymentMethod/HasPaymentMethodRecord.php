<?php

namespace Paytic\Payments\Legacy\Models\AbstractModels\HasPaymentMethod;

use Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethod\HasPaymentMethodRecordTrait;

/**
 * Trait HasPaymentMethodRecord
 * @package Paytic\Payments\Models\AbstractModels\HasPaymentMethod
 * @deprecated use HasPaymentMethodRecordTrait
 */
trait HasPaymentMethodRecord
{
    use HasPaymentMethodRecordTrait;
}
