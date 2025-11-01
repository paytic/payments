<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

use Paytic\Payments\PaymentMethods\Actions\FindPaymentMethodsForTenant;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait MethodsControllerTrait
{
    use AbstractControllerTrait;

    public function index(): void
    {
        $existingMethods = FindPaymentMethodsForTenant::for($this->getPaymentTenant());

        $this->payload()->with([
            'existingMethods' => $existingMethods,
        ]);
    }

    abstract protected function getPaymentTenant();

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::methods());
    }
}
