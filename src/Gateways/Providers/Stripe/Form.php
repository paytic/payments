<?php

namespace ByTIC\Payments\Gateways\Providers\Stripe;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;
use ByTIC\Payments\Models\Methods\Types\CreditCards;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Form
 * @package ByTIC\Payments\Gateways\Providers\Stripe
 */
class Form extends AbstractForm
{
    public function initElements()
    {
        parent::initElements();
        $this->initElementSandbox();

        $this->addInput('apiKey', 'apiKey', false);
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
