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
        $key = $this->getManager()->getPaymentMethodField();
        $this->{$key} = $paymentMethod->id;
        $this
            ->getRelation(HasPaymentMethodRepositoryInterface::RELATION_PAYMENT_METHOD)
            ->setResults($paymentMethod);
        return $this;
    }

    public function supportsCurrency($currency)
    {
        return $this->getPaymentMethod()->supportsCurrency($currency);
    }

    /**
     */
    public function getCurrenciesModels(): ?array
    {
        return $this->getPaymentMethod()->getCurrenciesModels();
    }

    /**
     * @return null|array
     */
    public function getCurrenciesArray(): ?array
    {
        return $this->getPaymentMethod()->getCurrenciesArray();
    }
}