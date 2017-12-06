<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay;

use ByTIC\Omnipay\Mobilpay\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

//use ByTIC\Common\Payments\Gateways\Providers\Mobilpay\Gateway as AbstractGateway;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;

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

//    /**
//     * @return bool
//     */
//    public function isActive()
//    {
//        $this->validateFilePath('certificate');
//        $this->validateFilePath('privateKey');
//
//        if ($this->getSandbox() && is_file($this->getCertificate())) {
//            return true;
//        }
//
//        return false;
//    }
}
