<?php

namespace ByTIC\Payments\Exception;

use Omnipay\Common\AbstractGateway;

/**
 * Class RequestNotSupportedException
 * @package ByTIC\Payments\Exception
 */
class RequestNotSupportedException extends InvalidArgumentException
{

    /**
     * @param string $request
     * @param AbstractGateway|null $gateway
     * @return self
     */
    public static function create(string $request, AbstractGateway $gateway = null): self
    {
        return new self(
            sprintf(
                'Request %s is not supported for %s',
                $request, $gateway->getName()
            ));
    }
}