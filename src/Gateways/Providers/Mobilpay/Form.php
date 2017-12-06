<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Form as AbstractForm;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Form
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay
 */
class Form extends AbstractForm
{
    protected $files = [];

    public function initElements()
    {
        $this->initElementSandbox();
        $this->addInput('signature', 'Signature', false);
    }

    public function getDataFromModel()
    {
        parent::getDataFromModel();
        $model = $this->getForm()->getModel();
        $options = $model->getOption($this->getGateway()->getName());

        $files = ['certificate', 'privateKey'];
        foreach ($files as $fileType) {
            $this->addFile($fileType.'Upload', $fileType.' File', false);
            $this->getForm()->getDisplayGroup($this->getGateway()->getLabel())
                ->addElement($this->getForm()->getElement('mobilpay['.$fileType.'Upload]'));

            $fileOptionValue = isset($options[$fileType]) ? $options[$fileType] : null;
            if (strlen($fileOptionValue) > 5) {
                $this->addTextarea($fileType, $fileType.' Content', true);
                $element = $this->getForm()->getElement('mobilpay['.$fileType.']');
                $element->setAttrib('readonly', 'readonly');
                $element->setValue($fileOptionValue);

                $this->getForm()->getDisplayGroup($this->getGateway()->getLabel())
                    ->addElement($this->getForm()->getElement('mobilpay['.$fileType.']'));
            }
        }
    }

    /**
     * @return bool
     */
    public function processValidation()
    {
        parent::processValidation();

        if ($_FILES['mobilpay']) {
            $files = ['certificate', 'privateKey'];
            foreach ($files as $fileType) {
                $element = $this->getForm()->getElement('mobilpay['.$fileType.'Upload]');

                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $element->getValue();
                if ($uploadedFile instanceof UploadedFile) {
                    if ($uploadedFile->isValid()) {
                        $extension = $fileType == 'certificate' ? 'cer' : 'key';
                        if ($uploadedFile->getClientOriginalExtension() != $extension) {
                            $element->addError(
                                'Invalid extension ['.$extension.']['.$uploadedFile->getClientOriginalName().']'
                            );
                        }
                    } else {
                        $element->addError($uploadedFile->getErrorMessage());
                    }
                }
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function generateModelOptions()
    {
        $options = parent::generateModelOptions();

        $files = ['certificate', 'privateKey'];

        foreach ($files as $fileType) {
            $element = $this->getForm()->getElement('mobilpay['.$fileType.'Upload]');
            if (!$element->isError()) {
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $element->getValue();
                if ($uploadedFile instanceof UploadedFile && $uploadedFile->isValid()) {
                    $options[$fileType] = file_get_contents($uploadedFile->getRealPath());
                }
            }
        }

        return $options;
    }
}
