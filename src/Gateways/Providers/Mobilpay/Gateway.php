<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay;

use ByTIC\Omnipay\Mobilpay\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\OverwriteServerCompletePurchaseTrait;
use ByTIC\Payments\Gateways\Providers\Mobilpay\FileLoader\HasFileLoader;

//use ByTIC\Common\Payments\Gateways\Providers\Mobilpay\Gateway as AbstractGateway;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;
    use OverwriteServerCompletePurchaseTrait;
    use HasFileLoader;

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
}
