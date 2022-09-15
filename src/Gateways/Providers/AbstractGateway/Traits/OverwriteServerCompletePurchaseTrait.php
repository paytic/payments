<?php

namespace Paytic\Payments\Gateways\Providers\AbstractGateway\Traits;

use Omnipay\Common\Message\RequestInterface;

/**
 * Trait OverwriteServerCompletePurchaseTrait
 * @package Paytic\Payments\Gateways\Providers\AbstractGateway\Traits
 */
trait OverwriteServerCompletePurchaseTrait
{
    // ------------ REQUESTS ------------ //

    /**
     * @param array $parameters
     * @return RequestInterface|null
     */
    public function serverCompletePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequestWithInternalCheck('ServerCompletePurchaseRequest', $parameters);
    }
}
