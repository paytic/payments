<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

use Paytic\Payments\MethodLinks\Actions\AddPaymentMethodLinksForTenant;
use Paytic\Payments\MethodLinks\Actions\FindPaymentMethodLinksForTenant;
use Paytic\Payments\PaymentMethods\Actions\FindPaymentMethodsForTenant;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait MethodLinksControllerTrait
{
    use AbstractControllerTrait;

    public function add()
    {
        $tenantName = $this->getRequest()->get('tenant');
        $tenant = $this->checkForeignModelFromRequest($tenantName, ['tenant_id', 'id']);

        $paymentMethod = PaymentsModels::methods()->findOne($this->getRequest()->get('id_payment_method'));

        AddPaymentMethodLinksForTenant::for($tenant)
            ->withPaymentMethod($paymentMethod)
            ->handle();

        $redirectUrl = $this->getRequest()->headers->get('referer');

        $this->redirect($redirectUrl);
    }

    public function tenant()
    {
        $tenantName = $this->getRequest()->get('tenant');
        $tenant = $this->checkForeignModelFromRequest($tenantName, ['tenant_id', 'id']);

        $availableMethods = FindPaymentMethodsForTenant
            ::for($this->getPaymentTenant())
            ->fetch();

        $methodLinks = FindPaymentMethodLinksForTenant::for($tenant)->fetch();

        $this->payload()->with([
            'methodLinks' => $methodLinks,
            'availableMethods' => $availableMethods,
            'tenant' => $tenant,
        ]);
    }

    abstract protected function getPaymentTenant();

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::methodLinks());
    }
}
