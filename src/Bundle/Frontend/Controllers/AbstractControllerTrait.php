<?php

namespace Paytic\Payments\Bundle\Frontend\Controllers;

use ByTIC\Controllers\Behaviors\Models\HasAfterActions;
use Nip\Controllers\Response\ResponsePayload;
use Nip\View\View;
use Paytic\Payments\Bundle\Library\View\ViewUtility;

/**
 * @method ResponsePayload payload()
 */
trait AbstractControllerTrait
{
    use \Nip\Controllers\Traits\AbstractControllerTrait;
    use HasAfterActions;

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

        ViewUtility::registerViewPaths($view, 'frontend');
    }
}