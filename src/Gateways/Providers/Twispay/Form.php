<?php

namespace ByTIC\Payments\Gateways\Providers\Twispay;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;

/**
 * Class Form
 * @package ByTIC\Payments\Gateways\Providers\Euplatesc
 */
class Form extends AbstractForm
{
    public function initElements()
    {
        $this->initElementSandbox();
        $this->addInput('siteId', 'Site ID');
        $this->addInput('privateKey', 'Private key');
    }
}
