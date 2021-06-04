<?php

namespace ByTIC\Payments\Models\AbstractModels\HasPaymentMethod;


use ByTIC\Payments\Models\Methods\PaymentMethod;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Trait HasPaymentMethodRecord
 * @package ByTIC\Payments\Models\AbstractModels\HasPaymentMethod
 *
 * @property int $id_method
 */
trait HasPaymentMethodRepository
{

    public function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPaymentMethod();
    }

    protected function initRelationsPaymentMethod()
    {
        $this->belongsTo('PaymentMethod', ['class' => get_class(PaymentsModels::methods()), 'fk' => 'id_method']);
    }
}