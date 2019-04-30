<?php

namespace ByTIC\Payments\Gateways\Providers\Romcard\Message;

use ByTIC\Omnipay\Romcard\Message\PurchaseRequest as AbstractRequest;
use ByTIC\Payments\Gateways\Providers\Romcard\Helper;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Romcard\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @inheritdoc
     */
    public function initialize(array $parameters = [])
    {
        if (isset($parameters['orderName'])) {
            $parameters['description'] = $parameters['orderName'];
        }

        return parent::initialize($parameters);
    }
}
