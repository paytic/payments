<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay;

use ByTIC\Common\Payments\Models\Methods\Files\MobilpayFile;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;
use Nip_File_System;

/**
 * Class Form
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay
 */
class Form extends AbstractForm
{
    public function initElements()
    {
        parent::initElements();
        $this->initElementSandbox();
        $this->addInput('signature', 'Signature', false);

        $this->addFile('file', 'Certificate', false);
        $this->addTextarea('certificate', 'Certificate', false);
        $element = $this->getForm()->getElement('mobilpay[certificate]');
        $element->setAttrib('readonly', 'readonly');

        $this->addFile('private-key', 'Private key', false);
        $this->addTextarea('privateKey', 'Private key', false);
        $element = $this->getForm()->getElement('mobilpay[privateKey]');
        $element->setAttrib('readonly', 'readonly');
    }

    public function getDataFromModel()
    {
        parent::getDataFromModel();
    }

    /**
     * @return bool
     */
    public function processValidation()
    {
        parent::processValidation();

        if ($_FILES['mobilpay']) {
            $publicData = $this->getForm()->getElement('mobilpay[file]')->getValue();
            if (is_array($publicData) && $publicData['tmp_name']) {
                $errorPublic = Nip_File_System::instance()->getUploadError(
                    $publicData,
                    $this->getFileModel('public.cer')->getExtensions()
                );
                if ($errorPublic) {
                    $this->getForm()->getElement('mobilpay[file]')->addError($errorPublic);
                }
            }

            $privateData = $this->getForm()->getElement('mobilpay[private-key]')->getValue();
            if (is_array($privateData) && $privateData['tmp_name']) {
                $errorPrivate = Nip_File_System::instance()->getUploadError(
                    $privateData,
                    $this->getFileModel('private.key')->getExtensions());

                if ($errorPrivate) {
                    $this->getForm()->getElement('mobilpay[private-key]')->addError($errorPrivate);
                }
            }
        }

        return true;
    }

    /**
     * @param $type
     * @return MobilpayFile
     */
    public function getFileModel($type)
    {
        if (!$this->files[$type]) {
            $model = $this->getForm()->getModel();

            return $model->getNewFile('Mobilpay');
        }

        return $this->files[$type];
    }

    /**
     * @return array
     */
    public function getOptionsForSaveToModel()
    {
        $options = parent::getOptionsForSaveToModel();
        unset($options['file'], $options['private-key']);
        return $options;
    }

    /**
     * @return bool
     */
    public function process()
    {
        parent::process();

        $model = $this->getForm()->getModel();
        $options = $model->getPaymentGatewayOptions();

        $files = ['file' => 'certificate', 'private-key' => 'privateKey'];
        foreach ($files as $file => $variable) {
            $fileData = $this->getForm()->getElement('mobilpay[' . $file . ']')->getValue();
            if (is_array($fileData) && $fileData['tmp_name']) {
                $content = file_get_contents($fileData["tmp_name"]);
                $options[$variable] = $content;
            }
        }

        $model->setPaymentGatewayOptions($options);
        $model->saveRecord();

        return true;
    }
}
