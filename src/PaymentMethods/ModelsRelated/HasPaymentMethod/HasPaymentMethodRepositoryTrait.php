<?php

namespace Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethod;

use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait HasPaymentMethodRepositoryTrait
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
        $this->belongsTo(
            HasPaymentMethodRepositoryInterface::RELATION_PAYMENT_METHOD,
            [
                'class' => PaymentsModels::methodsClass(),
                'fk' => $this->getPaymentMethodField(),
            ]
        );
    }

    public function getPaymentMethodField(): string
    {
        return 'id_payment_method';
    }
}