<?php

namespace ByTIC\Payments\Gateways\Providers\Payu;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;

/**
 * Class Form
 * @package ByTIC\Payments\Gateways\Providers\Payu
 */
class Form extends AbstractForm
{
    public function initElements()
    {
        $this->addInput('merchant', 'Merchant');
        $this->addInput('secretKey', 'Secret Key');
    }
}
