<?php

namespace ByTIC\Common\Payments\Gateways\Providers\Euplatesc;

use ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;

/**
 * Class Form
 * @package ByTIC\Common\Payments\Gateways\Providers\Euplatesc
 */
class Form extends AbstractForm
{

    public function initElements()
    {
        $this->addInput('siteId', 'MID');
        $this->addInput('key', 'Key');
    }
}
