<?php

namespace ByTIC\Payments\Gateways\Providers\Romcard\Message;

use Paytic\Omnipay\Romcard\Message\PurchaseRequest as AbstractRequest;

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
