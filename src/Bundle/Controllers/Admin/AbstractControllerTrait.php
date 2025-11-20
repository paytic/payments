<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

use Nip\Controllers\Response\ResponsePayload;
use Nip\View\View;
use Paytic\Payments\Bundle\Library\View\ViewUtility;

/**
 * @method ResponsePayload payload()
 */
trait AbstractControllerTrait
{
    use \Nip\Controllers\Traits\AbstractControllerTrait;

    public function registerViewPaths(View $view): void
    {
        parent::registerViewPaths($view);

        ViewUtility::registerViewPaths($view, 'admin');
    }
}