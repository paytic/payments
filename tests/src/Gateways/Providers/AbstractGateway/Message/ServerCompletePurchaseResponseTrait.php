<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message;

use ByTIC\Payments\Gateways\Providers\Euplatesc\Message\ServerCompletePurchaseResponse;

/**
 * Trait ServerCompletePurchaseResponseTrait
 * @package ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message
 */
trait ServerCompletePurchaseResponseTrait
{
    public function testHasSendMethod()
    {
        $response = $this->getNewResponse();

        static::assertTrue(method_exists($response, 'send'));
    }

    abstract protected function getNewResponse();
}
