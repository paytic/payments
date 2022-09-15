<?php

namespace Paytic\Payments\Gateways\Providers\Paylike;

use Paytic\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;
use Paytic\Payments\Models\Methods\Types\CreditCards;

/**
 * Class Form
 * @package Paytic\Payments\Gateways\Providers\Paylike
 */
class Form extends AbstractForm
{
    public function initElements()
    {
        parent::initElements();
        $this->initElementSandbox();

        $this->addInput('public_key', 'Public key', false);
        $this->addInput('private_key', 'Private key', false);
    }

    public function getDataFromModel()
    {
        $type = $this->getForm()->getModel()->getType();
        if ($type instanceof CreditCards) {
            $type->getGateway();
        }
        parent::getDataFromModel();
    }

    /**
     * @return bool
     */
    public function processValidation()
    {
        parent::processValidation();

        return true;
    }

    /**
     * @return bool
     */
    public function process()
    {
        parent::process();

        $model = $this->getForm()->getModel();
        $options = $model->getPaymentGatewayOptions();

        $model->setPaymentGatewayOptions($options);
        $model->saveRecord();

        return $options;
    }
}
