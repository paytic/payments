<?php

namespace ByTIC\Payments\Gateways\Providers\Librapay\Message;

use ByTIC\Omnipay\Librapay\Message\PurchaseRequest as AbstractRequest;
use ByTIC\Payments\Gateways\Providers\Librapay\Helper;

/**
 * Class PurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Librapay\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @inheritdoc
     */
    public function initialize(array $parameters = [])
    {
        if (isset($parameters['order'])) {
            $parameters['order'] = Helper::decodeOrderId($parameters['order']);
        }

        return parent::initialize($parameters);
    }
}
