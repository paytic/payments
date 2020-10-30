<?php

namespace ByTIC\Payments\Gateways\Providers\Stripe\Message;

use Omnipay\Stripe\Message\PaymentIntents\PurchaseRequest as AbstractRequest;
use ByTIC\Payments\Gateways\Providers\Librapay\Helper;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Stripe\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @inheritdoc
     */
    public function initialize(array $parameters = [])
    {
        if (!isset($parameters['paymentMethod'])) {
            $parameters['paymentMethod'] = 'card';
        }

        return parent::initialize($parameters);
    }
}
