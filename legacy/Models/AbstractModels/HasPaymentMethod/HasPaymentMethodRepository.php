<?php

namespace Paytic\Payments\Models\AbstractModels\HasPaymentMethod;

use Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethod\HasPaymentMethodRepositoryTrait;

/**
 * Trait HasPaymentMethodRecord
 * @package Paytic\Payments\Models\AbstractModels\HasPaymentMethod
 * @deprecated use HasPaymentMethodRepositoryTrait
 */
trait HasPaymentMethodRepository
{
    use HasPaymentMethodRepositoryTrait;


    public function getPaymentMethodField(): string
    {
        return 'id_method';
    }
}
