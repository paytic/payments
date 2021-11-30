<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Romcard\Message;

use ByTIC\Payments\Gateways\Providers\Romcard\Message\CompletePurchaseResponse;
use ByTIC\Payments\Gateways\Providers\Romcard\Message\CompletePurchaseRequest;
use Paytic\Payments\Tests\AbstractTest;
use Paytic\Payments\Tests\Gateways\Message\CompletePurchaseResponseTestTrait;
use Symfony\Component\HttpFoundation\Request;

class CompletePurchaseResponseTest extends AbstractTest
{
    use CompletePurchaseResponseTestTrait;

    protected function getNewResponse()
    {
        $request = new CompletePurchaseRequest($this->client, new Request());

        return new CompletePurchaseResponse($request, []);
    }
}
