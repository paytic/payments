<?php

namespace Paytic\Payments\Models\AbstractModels\HasPaymentMethod;

use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait HasPaymentMethodRecord
 * @package Paytic\Payments\Models\AbstractModels\HasPaymentMethod
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
