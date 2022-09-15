<?php

namespace Paytic\Payments\Gateways\Providers\Romcard;

use Paytic\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;

/**
 * Class Form
 * @package Paytic\Payments\Gateways\Providers\Euplatesc
 */
class Form extends AbstractForm
{
    public function initElements()
    {
        $this->initElementSandbox();

        $this->addInput('merchantName', 'Merchant Name');
        $this->addInput('merchantEmail', 'Merchant Email');
        $this->addInput('merchantUrl', 'Merchant Url');
        $this->addInput('terminal', 'Terminal');
        $this->addInput('key', 'Key');
    }
}
