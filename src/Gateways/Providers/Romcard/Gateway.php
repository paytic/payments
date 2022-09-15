<?php

namespace Paytic\Payments\Gateways\Providers\Romcard;

use Paytic\Omnipay\Romcard\Gateway as AbstractGateway;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Paytic\Payments\Gateways\Providers\Romcard\Message\CompletePurchaseRequest;
use Paytic\Payments\Gateways\Providers\Romcard\Message\PurchaseRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class Gateway
 * @package Paytic\Payments\Gateways\Providers\Romcard
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritdoc
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = []): RequestInterface
    {
        $parameters['endpointUrl'] = $this->getEndpointUrl();

        return $this->createRequestWithInternalCheck('PurchaseRequest', $parameters);
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritdoc
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = []): RequestInterface
    {
        /** @var CompletePurchaseRequest $request */
        $request = $this->createRequestWithInternalCheck('CompletePurchaseRequest', $parameters);
        $request->setSaleRequest($this->sale($parameters));
        return $request;
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
