<?php

namespace ByTIC\Payments\Gateways\Providers\Romcard;

use ByTIC\Omnipay\Romcard\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use ByTIC\Payments\Gateways\Providers\Romcard\Message\PurchaseRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Romcard
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
        if (strlen($this->getTerminal()) > 5
            && strlen($this->getKey()) > 5
            && strlen($this->getMerchantName()) > 5
            && strlen($this->getMerchantEmail()) > 5
            && strlen($this->getMerchantUrl()) > 5
        ) {
            return true;
        }

        return false;
    }
}
