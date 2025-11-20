<?php

namespace Paytic\Payments\MethodLinks\ModelsRelated\HasPaymentMethodLinks;

use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait HasPaymentMethodLinksRepositoryTrait
{

    public function initRelations(): void
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments(): void
    {
        $this->initRelationsPaymentMethods();
    }

    protected function initRelationsPaymentMethods(): void
    {
        $this->morphMany(
            'PaymentMethods',
            [
                'class' => PaymentsModels::methodLinksClass(),
                'morphPrefix' => 'tenant',
                'morphTypeField' => 'tenant',
            ]
        );
    }
}