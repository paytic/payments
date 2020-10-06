<?php

namespace ByTIC\Payments\Gateways\Providers\PlatiOnline\Message;

use ByTIC\Omnipay\PlatiOnline\Message\CompletePurchaseRequest as AbstractCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\PlatiOnline\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\PlatiOnline\Message
 *
 * @method CompletePurchaseResponse send
 */
class CompletePurchaseRequest extends AbstractCompletePurchaseRequest
{
    use HasModelRequest;
    use Traits\CompletePurchaseTrait;
}
