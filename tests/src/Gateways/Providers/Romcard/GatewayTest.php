<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Gateways\Providers\Romcard;

use Http\Discovery\Psr17FactoryDiscovery;
use Paytic\Omnipay\Romcard\Message\PurchaseResponse;
use Paytic\Omnipay\Romcard\Message\SaleRequest;
use Paytic\Payments\Gateways\Providers\Romcard\Gateway;
use Paytic\Payments\Gateways\Providers\Romcard\Message\CompletePurchaseRequest;
use Paytic\Payments\Tests\Fixtures\Records\Gateways\Providers\Romcard\RomcardData;
use Paytic\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;
use Paytic\Payments\Tests\Gateways\GatewayTest as AbstractGatewayTest;

/**
 * Class GatewayTest.
 */
class GatewayTest extends AbstractGatewayTest
{
    public function testPurchaseResponse()
    {
        //        Debug::debug($this->gateway->getParameters());
        $request = $this->gateway->purchaseFromModel($this->purchase);

        /** @var PurchaseResponse $response */
//        Debug::debug($request->getParameters());
        $response = $request->send();
        self::assertInstanceOf(PurchaseResponse::class, $response);

        $data = $response->getRedirectData();
        self::assertSame('000000060001099', $data['MERCHANT']);

        $gatewayResponse = $this->client->request(
            'POST',
            $response->getRedirectUrl(),
            ['Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'],
            Psr17FactoryDiscovery::findStreamFactory()->createStream(http_build_query($data, '', '&'))
        );
        self::assertSame(200, $gatewayResponse->getStatusCode());

        // Validate first Response
        $body = $gatewayResponse->getBody()->__toString();

        self::assertMatchesRegularExpression('/Tranzactie Aprobata/', $body);
        self::assertMatchesRegularExpression('/value="Aproba" name="SEND_BUTTON"/', $body);
    }

    public function testCompletePurchaseRequest()
    {
        /** @var CompletePurchaseRequest $request */
        $request = $this->gateway->completePurchase([]);

        self::assertInstanceOf(CompletePurchaseRequest::class, $request);
        self::assertInstanceOf(SaleRequest::class, $request->getSaleRequest());
    }

    public function testIsActive()
    {
        $gateway = new Gateway();
        self::assertFalse($gateway->isActive());

        $gateway->setTerminal('999999');
        $gateway->setKey('999999');
        $gateway->setMerchantName('999999');
        $gateway->setMerchantEmail('999999');

        self::assertFalse($gateway->isActive());

        $gateway->setMerchantUrl('9');

        self::assertFalse($gateway->isActive());

        $gateway->setMerchantUrl('999999');

        self::assertTrue($gateway->isActive());
    }

    protected function setUp(): void
    {
        parent::setUp();

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->purchase->getPaymentMethod();
        $paymentMethod->options = trim(RomcardData::getMethodOptions());

        $this->purchase->created = date('Y-m-d H:i:s');

        $this->gateway = $paymentMethod->getType()->getGateway();
    }
}
