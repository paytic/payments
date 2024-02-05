<?php

namespace Paytic\Payments\Bundle\Controllers\Frontend;

use Nip\Controllers\Response\ResponsePayload;
use Nip\View\View;
use Paytic\Payments\Bundle\Library\View\ViewUtility;

/**
 * @method ResponsePayload payload()
 */
trait AbstractControllerTrait
{
    use \Nip\Controllers\Traits\AbstractControllerTrait;

    public function getModelForm($model, $action = null)
    {
        $class = $this->getModelFormClass($model, $action);
        $form = new $class();
        $form->setModel($model);
        return $form;
    }

    public function registerViewPaths(View $view): void
    {
        parent::registerViewPaths($view);

        ViewUtility::registerViewPaths($view, 'admin');
    }
}