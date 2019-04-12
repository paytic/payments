<?php

namespace ByTIC\Payments\Gateways\Providers\Euplatesc\Message;

use ByTIC\Omnipay\Euplatesc\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Euplatesc\Message\Traits\CompletePurchaseTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Euplatesc\Message
 */
class CompletePurchaseRequest extends AbstractCompletePurchaseRequest
{
    use HasModelRequest;
    use CompletePurchaseTrait;
}
