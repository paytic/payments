<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Payu\Message;

use ByTIC\Payments\Gateways\Providers\Payu\Message\ServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\Payu\Message\ServerCompletePurchaseResponse;
use Paytic\Payments\Tests\AbstractTest;
use Paytic\Payments\Tests\Gateways\Message\ServerCompletePurchaseResponseTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServerCompletePurchaseResponseTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\Payu\Message
 */
class ServerCompletePurchaseResponseTest extends AbstractTest
{
    use ServerCompletePurchaseResponseTrait;

    /**
     * @return ServerCompletePurchaseResponse
     */
    protected function getNewResponse()
    {
        $request = new ServerCompletePurchaseRequest($this->client, new Request());

        return new ServerCompletePurchaseResponse($request, []);
    }
}
