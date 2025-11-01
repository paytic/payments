<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

use Paytic\Payments\MethodLinks\Actions\FindPaymentMethodLinksForTenant;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait MethodLinksControllerTrait
{
    use AbstractControllerTrait;

    public function tenant()
    {
        $tenantName = $this->getRequest()->get('tenant');
        $tenant = $this->checkForeignModelFromRequest($tenantName, ['tenant_id', 'id']);

        $methodLinks = FindPaymentMethodLinksForTenant::for($tenant);

        $this->payload()->with([
            'methodLinks' => $methodLinks,
            'tenant' => $tenant,
        ]);
    }

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::methodLinks());
    }
}
