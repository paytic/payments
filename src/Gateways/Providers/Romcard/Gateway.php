<?php

namespace Paytic\Payments\Gateways\Providers\Romcard;

use Omnipay\Common\Message\RequestInterface;
use Paytic\Omnipay\Romcard\Gateway as AbstractGateway;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Paytic\Payments\Gateways\Providers\Romcard\Message\CompletePurchaseRequest;
use Paytic\Payments\Gateways\Providers\Romcard\Message\PurchaseRequest;

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
        if ($this->validateParameterHasLength($this->getTerminal(), 5)
            && $this->validateParameterHasLength($this->getKey(), 5)
            && $this->validateParameterHasLength($this->getMerchantName(), 5)
            && $this->validateParameterHasLength($this->getMerchantEmail(), 5)
            && $this->validateParameterHasLength($this->getMerchantUrl(), 5)
        ) {
            return true;
        }

        return false;
    }

    protected function validateParameterHasLength($value, $len)
    {
        if (!is_string($value)) {
            return false;
        }
        if (strlen($value) < $len) {
            return false;
        }
        return true;
    }
}
