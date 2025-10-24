<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait MethodsControllerTrait
{
    use AbstractControllerTrait;

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::methods());
    }
}
