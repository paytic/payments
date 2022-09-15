<?php

namespace Paytic\Payments\Exception;

use Omnipay\Common\AbstractGateway;

/**
 * Class RequestNotSupportedException
 * @package Paytic\Payments\Exception
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
                $request,
                $gateway->getName()
            )
        );
    }
}
