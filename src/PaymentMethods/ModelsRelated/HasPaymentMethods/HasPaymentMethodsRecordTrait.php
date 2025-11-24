<?php

namespace Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethods;

use Nip\Records\Collections\Associated;
use Paytic\Payments\Models\Methods\PaymentMethod;

/**
 * @method PaymentMethod[]|Associated getPaymentMethods()
 */
trait HasPaymentMethodsRecordTrait
{
}