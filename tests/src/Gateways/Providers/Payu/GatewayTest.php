<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Payu;

use Paytic\Omnipay\Payu\Message\PurchaseResponse;
use ByTIC\Payments\Gateways\Providers\Payu\Gateway;
use ByTIC\Payments\Gateways\Providers\Payu\Message\CompletePurchaseResponse;
use ByTIC\Payments\Gateways\Providers\Payu\Message\ServerCompletePurchaseResponse;
use ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Payu\PayuData;
use Paytic\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;
use Paytic\Payments\Tests\Gateways\GatewayTest as AbstractGatewayTest;
use Http\Discovery\Psr17FactoryDiscovery;

/**
 * Class TraitsTest
 * @package ByTIC\Common\Tests\Unit\Payments\Providers\Payu
 */
class GatewayTest extends AbstractGatewayTest
{
    public function testPurchaseResponse()
    {
//        Debug::debug($this->gateway->getParameters());
        $request = $this->gateway->purchaseFromModel($this->purchase);
//        Debug::debug($this->gateway->getParameters());
//        Debug::debug($request->getParameters());

//        $this->client->setDefaultOption('verify', false);

        /** @var PurchaseResponse $response */
        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);

        $data = $response->getRedirectData();
        self::assertSame('GALANTOM', $data['MERCHANT']);

        $payuResponse = $this->client->request(
            'POST',
            $response->getRedirectUrl(),
            ['Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'],
            Psr17FactoryDiscovery::findStreamFactory()->createStream(http_build_query($data, '', '&'))
        );
        self::assertSame(200, $payuResponse->getStatusCode());

        $body = $payuResponse->getBody()->__toString();
        self::assertMatchesRegularExpression('/checkout.php/', $body);
        self::assertMatchesRegularExpression('/CART_ID=/', $body);
    }

    public function testCompletePurchaseResponse()
    {
        $httpRequest = PayuData::getConfirmAuthorizedRequest();
        $response = $this->doCompletePurchaseResponse($httpRequest);
        self::assertEquals(null, $response->getModel()->status);
    }

    /**
     * @param $httpRequest
     * @return CompletePurchaseResponse
     */
    protected function doCompletePurchaseResponse($httpRequest)
    {
        /** @var CompletePurchaseResponse $response */
        $response = $this->gatewayManager::detectItemFromHttpRequest(
            $this->purchaseManager,
            'completePurchase',
            $httpRequest
        );

        self::assertInstanceOf(CompletePurchaseResponse::class, $response);

        self::assertTrue($response->isSuccessful());
        self::assertEquals(37250, $response->getModel()->getPrimaryKey());

        return $response;
    }

    public function testCompletePurchaseResponseAfterServerCompletePurchaseAuthorizedResponse()
    {
        $this->purchase->status = 'active';
        $httpRequest = PayuData::getConfirmAuthorizedRequest();
        $response = $this->doCompletePurchaseResponse($httpRequest);
        self::assertEquals('active', $response->getModel()->status);
    }

    public function testServerCompletePurchaseAuthorizedResponse()
    {
        $httpRequest = PayuData::getIpnAuthorizedRequest();

        /** @var ServerCompletePurchaseResponse $response */
        $response = $this->gatewayManager::detectItemFromHttpRequest(
            $this->purchaseManager,
            'serverCompletePurchase',
            $httpRequest
        );

        self::assertInstanceOf(ServerCompletePurchaseResponse::class, $response);
        $data = $response->getData();
        self::assertSame($data['hash'], $data['hmac']);
        self::assertTrue($response->isSuccessful());

        $content = $response->getContent();
        self::assertStringStartsWith('<EPAYMENT>', $content);
        self::assertStringEndsWith('</EPAYMENT>', $content);
    }

    protected function setUp() : void
    {
        parent::setUp();

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->purchase->getPaymentMethod();
        self::assertInstanceOf(PaymentMethod::class, $paymentMethod);

        $paymentMethod->options = trim(PayuData::getMethodOptions());

        $this->purchase->created = date('Y-m-d H:i:s');


        $this->gateway = $paymentMethod->getType()->getGateway();
        self::assertInstanceOf(Gateway::class, $this->gateway);
    }

    /**
     * @inheritDoc
     */
    protected function generatePurchaseManagerMock($purchase)
    {
        $manager = parent::generatePurchaseManagerMock($purchase);
        $manager->shouldReceive('getPaymentsUrlPK')->andReturn('hash');
        $manager->shouldReceive('findOneByHash')->andReturn($purchase);
        return $manager;
    }
}
