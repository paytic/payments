<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message;

trait CompletePurchaseResponseTestTrait
{
    public function testHasConfirmHtmlTraitTrait()
    {
        $response = $this->getNewResponse();

        static::assertTrue(method_exists($response, 'getViewFile'));
        static::assertTrue(method_exists($response, 'getView'));
    }

    abstract protected function getNewResponse();
}
