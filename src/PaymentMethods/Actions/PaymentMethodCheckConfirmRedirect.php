<?php

namespace Paytic\Payments\PaymentMethods\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\PaymentMethods\Models\PaymentMethodInterface;

/**
 *
 */
class PaymentMethodCheckConfirmRedirect extends Action
{
    use HasSubject;

    public function execute(): bool
    {
        /** @var PaymentMethod $method */
        $method = $this->getSubject();
        if (!($method instanceof PaymentMethodInterface)) {
            return false;
        }
        return $method->getType()->checkConfirmRedirect();
    }

}