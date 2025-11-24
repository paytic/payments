<?php

namespace Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethods;

use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait HasPaymentMethodsRepositoryTrait
{

    public function initRelations(): void
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments(): void
    {
        $this->initRelationsPaymentMethod();
    }

    protected function initRelationsPaymentMethod(): void
    {
        $this->morphToMany(
            'PaymentMethods',
            [
                'class' => PaymentsModels::methodsClass(),
            ]
        );
    }
}