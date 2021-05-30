<?php

namespace ByTIC\Payments\Models\AbstractModels\HasPaymentMethod;


use ByTIC\Payments\Models\Methods\PaymentMethod;

/**
 * Trait HasPaymentMethodRecordTrait
 * @package ByTIC\Payments\Models\AbstractModels\HasPaymentMethod
 *
 * @property int $id_method
 */
trait HasPaymentMethodRecordTrait
{
    /**
     * @param PaymentMethod $method
     */
    public function populateFromPaymentMethod($method)
    {
        $this->id_method = is_object($method) ? $method->id : $method;
    }
}