<?php

namespace ByTIC\Payments\Gateways\Providers\Librapay;

use ByTIC\Omnipay\Librapay\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\Librapay\Message\PurchaseRequest;
use Omnipay\Common\Message\RequestInterface;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Librapay
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;
    /**
     * @inheritdoc
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = []): RequestInterface
    {
        $parameters['endpointUrl'] = $this->getEndpointUrl();
        return $this->createRequestWithInternalCheck('PurchaseRequest', $parameters);
    }
    /**
     * @return bool
     */
    public function isActive()
    {
        if (intval($this->getSiteId()) >= 5 && strlen($this->getPrivateKey()) > 10) {
            return true;
        }

        return false;
    }
}
