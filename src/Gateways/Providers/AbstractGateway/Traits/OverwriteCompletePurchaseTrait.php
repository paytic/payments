<?php

namespace Paytic\Payments\Gateways\Providers\AbstractGateway\Traits;

use Omnipay\Common\Message\RequestInterface;

/**
 * Trait OverwriteCompletePurchaseTrait
 * @package Paytic\Payments\Gateways\Providers\AbstractGateway\Traits
 */
trait OverwriteCompletePurchaseTrait
{
    // ------------ REQUESTS ------------ //
    /**
     * @param array $parameters
     * @return RequestInterface|null
     */
    public function completePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequestWithInternalCheck('completePurchase', $parameters);
    }
}
