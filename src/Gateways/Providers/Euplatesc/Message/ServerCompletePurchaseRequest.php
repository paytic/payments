<?php

namespace ByTIC\Payments\Gateways\Providers\Euplatesc\Message;

use ByTIC\Omnipay\Euplatesc\Message\ServerCompletePurchaseRequest as AbstractServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Euplatesc\Gateway;
use ByTIC\Payments\Gateways\Providers\Euplatesc\Helper;
use ByTIC\Payments\Gateways\Providers\Euplatesc\Message\Traits\CompletePurchaseTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class ServerCompletePurchaseRequest
 * @package ByTIC\Payments\Gateways\Providers\Euplatesc\Message
 */
class ServerCompletePurchaseRequest extends AbstractServerCompletePurchaseRequest
{
    use HasModelRequest;
    use CompletePurchaseTrait;
}
