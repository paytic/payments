<?php

namespace ByTIC\Payments\Gateways\Providers\Librapay\Message;

use ByTIC\Omnipay\Librapay\Message\ServerCompletePurchaseRequest as AbstractServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\Librapay\Helper;
use ByTIC\Payments\Gateways\Providers\Librapay\Message\Traits\CompletePurchaseTrait;

/**
 * Class ServerCompletePurchaseRequest
 * @package ByTIC\Payments\Gateways\Providers\Librapay\Message
 */
class ServerCompletePurchaseRequest extends AbstractServerCompletePurchaseRequest
{
    use CompletePurchaseTrait;
}
