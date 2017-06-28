<?php

namespace ByTIC\Payments\Gateways\Providers\Euplatesc;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;

/**
 * Class Form
 * @package ByTIC\Payments\Gateways\Providers\Euplatesc
 */
class Form extends AbstractForm
{

    public function initElements()
    {
        $this->addInput('mid', 'MID');
        $this->addInput('key', 'Key');
    }
}
