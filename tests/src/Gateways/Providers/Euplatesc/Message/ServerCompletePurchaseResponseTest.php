<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Euplatesc\Message;

use ByTIC\Payments\Gateways\Providers\Euplatesc\Message\ServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\Euplatesc\Message\ServerCompletePurchaseResponse;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message\ServerCompletePurchaseResponseTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServerCompletePurchaseResponseTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\Euplatesc\Message
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
