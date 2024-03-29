<?php

namespace Paytic\Payments\Gateways\Providers\Paylike;

use Paytic\Omnipay\Paylike\Gateway as AbstractGateway;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package Paytic\Payments\Gateways\Providers\Paylike
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;

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
        $publicKey = $this->getPublicKey();
        if (empty($publicKey) || strlen($publicKey) < 5) {
            return false;
        }
        $privateKey = $this->getPrivateKey();
        if (empty($privateKey) || strlen($privateKey) < 5) {
            return false;
        }
        return true;
    }
}
