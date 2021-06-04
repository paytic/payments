<?php

namespace ByTIC\Payments\Models\AbstractModels\HasPaymentMethod;


use ByTIC\Payments\Models\Methods\PaymentMethod;

/**
 * Trait HasPaymentMethodRecord
 * @package ByTIC\Payments\Models\AbstractModels\HasPaymentMethod
 *
 * @property int $id_method
 * @method PaymentMethod getPaymentMethod()
 */
trait HasPaymentMethodRecord
{
    /**
     * @param PaymentMethod $method
     */
    public function populateFromPaymentMethod($method)
    {
        if (is_object($method)) {
            $this->getRelation('PaymentMethod')->setResults($method);
            $method = $method->id;
        }
        $this->id_method = $method;
    }
}