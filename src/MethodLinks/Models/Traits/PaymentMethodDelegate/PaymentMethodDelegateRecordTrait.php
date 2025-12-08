<?php

namespace Paytic\Payments\MethodLinks\Models\Traits\PaymentMethodDelegate;

trait PaymentMethodDelegateRecordTrait
{

    public function getName($type = false)
    {
        return $this->getPaymentMethod()->getName($type);
    }

    public function getInternalName()
    {
        return $this->getPaymentMethod()->getInternalName();
    }

    public function getDescription()
    {
        return $this->getPaymentMethod()->getDescription();
    }

    public function getType()
    {
        return $this->getPaymentMethod()->getType();
    }

}