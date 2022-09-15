<?php

namespace Paytic\Payments\Gateways\Providers\Romcard\Message;

use Paytic\Omnipay\Romcard\Message\CompletePurchaseResponse as AbstractCompletePurchaseResponse;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;

/**
 * Class CompletePurchaseResponse
 * @package Paytic\Payments\Gateways\Providers\Romcard\Message
 */
class CompletePurchaseResponse extends AbstractCompletePurchaseResponse
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
