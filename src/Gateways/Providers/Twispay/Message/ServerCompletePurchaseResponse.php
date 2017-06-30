<?php

namespace ByTIC\Payments\Gateways\Providers\Twispay\Message;

use ByTIC\Omnipay\Twispay\Message\ServerCompletePurchaseResponse as AbstractServerCompletePurchaseResponse;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;

/**
 * Class ServerCompletePurchaseResponse
 * @package ByTIC\Omnipay\Twispay\Message
 */
class ServerCompletePurchaseResponse extends AbstractServerCompletePurchaseResponse
{
    use CompletePurchaseResponseTrait;

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return bool
     */
    protected function canProcessModel()
    {
        return true;
    }
}
