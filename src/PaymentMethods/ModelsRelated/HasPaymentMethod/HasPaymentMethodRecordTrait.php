<?php

namespace Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethod;

use Paytic\Payments\MethodLinks\Models\PaymentMethodLink;
use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\PaymentMethods\Models\PaymentMethodInterface;

/**
 * @property int $id_payment_method
 * @method PaymentMethod getPaymentMethod()
 */
trait HasPaymentMethodRecordTrait
{
    public function populateFromPaymentMethod(PaymentMethodInterface|PaymentMethodLink $paymentMethod): self
    {
        $paymentMethod = $paymentMethod instanceof PaymentMethodLink
            ? $paymentMethod->getPaymentMethod()
            : $paymentMethod;
        $this->id_payment_method = $paymentMethod->id;
        $this
            ->getRelation(HasPaymentMethodRepositoryInterface::RELATION_PAYMENT_METHOD)
            ->setResults($paymentMethod);
        return $this;
    }
}