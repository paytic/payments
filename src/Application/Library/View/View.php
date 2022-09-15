<?php

namespace Paytic\Payments\Application\Library\View;

use Paytic\Payments\Utility\PaymentsAssets;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class View
 * @package Paytic\Payments\Application\Library\View
 */
class View extends \Nip\View
{
    use SingletonTrait;

    /** @noinspection PhpMissingParentCallCommonInspection
     *
     * @return string
     */
    protected function generateBasePath(): string
    {
        return PaymentsAssets::basePath()
            . DIRECTORY_SEPARATOR . 'resources'
            . DIRECTORY_SEPARATOR . 'views';
    }
}
