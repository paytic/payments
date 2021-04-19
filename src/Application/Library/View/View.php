<?php

namespace ByTIC\Payments\Application\Library\View;

use ByTIC\Payments\Utility\PaymentsAssets;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class View
 * @package ByTIC\Payments\Application\Library\View
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
