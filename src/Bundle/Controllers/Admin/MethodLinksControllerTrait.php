<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait MethodLinksControllerTrait
{
    use AbstractControllerTrait;

    public function index()
    {

    }

    protected function getTenant()
    {
        return null;
    }

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::methodLinks());
    }
}
