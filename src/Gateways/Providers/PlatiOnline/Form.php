<?php

namespace ByTIC\Payments\Gateways\Providers\PlatiOnline;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;
use ByTIC\Payments\Models\Methods\Types\CreditCards;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Form
 * @package ByTIC\Payments\Gateways\Providers\PlatiOnline
 */
class Form extends AbstractForm
{
    public function initElements()
    {
        parent::initElements();
        $this->initElementSandbox();

        $this->addInput('loginId', 'Login ID', true);
        $this->addInput('website', 'Website', true);

        $this->addInput('initialVector', 'Initial Vector', true);
        $this->addInput('initialVectorItsn', 'Initial Vector Itsn', true);

        $this->addTextarea('publicKey', 'Public Key', true);

        $this->addTextarea('privateKey', 'Private key', true);
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