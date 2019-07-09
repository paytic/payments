<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay;

use ByTIC\Omnipay\Mobilpay\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\OverwriteServerCompletePurchaseTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;
    use OverwriteServerCompletePurchaseTrait;

    /**
     * @inheritDoc
     */
    public function initialize(array $parameters = [])
    {
        if (isset($parameters['private-key'])) {
            $parameters['privateKey'] = $parameters['private-key'];
            unset($parameters['private-key']);
        }

        if (isset($parameters['file']) && is_array($parameters['file'])) {
            $parameters['file'] = 'public.cer';
        }

        if (isset($parameters['privateKey']) && is_array($parameters['privateKey'])) {
            $parameters['file'] = 'private.key';
        }

        return parent::initialize($parameters);
    }

    /**
     * @param $certificate
     * @throws \Exception
     */
    public function setFile($certificate)
    {
        if ($certificate == 'public.cer') {
            $certificate = $this->getFilePath('certificate');
        }

        return parent::setCertificate($certificate);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function setPrivateKey(string $key)
    {
        if ($key == 'private.key') {
            $key = $this->getFilePath('privateKey');
        }

        return parent::setPrivateKey($key);
    }

    /**
     * @inheritDoc
     */
    public function setSandbox($value)
    {
        return $this->setTestMode($value == 'yes');
    }

    /**
     * @inheritDoc
     */
    public function getSandbox()
    {
        return $this->getTestMode() === true ? 'yes' : 'no';
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        if (strlen($this->getCertificate()) >= 5 && strlen($this->getPrivateKey()) > 10) {
            return true;
        }

        return false;
    }

    /**
     * @param $type
     * @return bool|string
     * @throws \Exception
     */
    protected function validateFilePath($type)
    {
        $path = $this->getParameter($type);
        if (strpos($path, DIRECTORY_SEPARATOR) === false) {
            $path = $this->getFilePath($type);
        }

        return $this->setParameter($type, $path);
    }

    /**
     * @param $type
     * @return string
     */
    protected function getFilePath($type)
    {
        $fileName = [
            'certificate' => 'public.cer',
            'privateKey' => 'private.key',
        ];

        return $this->getFileDirectoryPath().$fileName[$type];
    }

    /**
     * @return string
     */
    protected function getFileDirectoryPath()
    {
        return $this->getPaymentMethod() ? $this->getPaymentMethod()->getFilesDirectory() : null;
    }
}
