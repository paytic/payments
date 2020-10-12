<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\PlatiOnline\Message;

use ByTIC\Payments\Gateways\Providers\PlatiOnline\Message\ServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\PlatiOnline\Message\ServerCompletePurchaseResponse;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecord;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecordManager;
use ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message\ServerCompletePurchaseResponseTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServerCompletePurchaseResponseTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\PlatiOnline\Message
 */
class ServerCompletePurchaseResponseTest extends AbstractTest
{
    use ServerCompletePurchaseResponseTrait;

    public function testResponseForValidTransaction()
    {
        $httpRequest = $this->generateRequestFromFixtures(
            TEST_FIXTURE_PATH . '/requests/platiOnline/serverCompletePurchase/basicParams.php'
        );

        $model = \Mockery::mock(PurchasableRecord::class)->makePartial();
        $model->shouldReceive('getPaymentGateway')->andReturn(null);

        $modelManager = \Mockery::mock(PurchasableRecordManager::class)->makePartial();
        $modelManager->shouldReceive('findOne')->andReturn($model);

        $request = new ServerCompletePurchaseRequest($this->client, $httpRequest);
        $request->initialize($this->gatewayParams());
        $request->setModelManager($modelManager);

        $response = $request->send();
        self::assertInstanceOf(ServerCompletePurchaseResponse::class, $response);
        self::assertSame(false, $response->isCancelled());
        self::assertSame(false, $response->isPending());
        self::assertSame('error', $response->getModelResponseStatus());

//        $content = $response->getViewContent();
//
//        self::assertStringContainsString('++++', $content);
    }

    /**
     * @return ServerCompletePurchaseResponse
     */
    protected function getNewResponse()
    {
        $request = new ServerCompletePurchaseRequest($this->client, new Request());

        return new ServerCompletePurchaseResponse($request, []);
    }

    protected function gatewayParams()
    {
        return [
            'loginId' => getenv('PLATIONLINE_LOGIN_ID'),
            'publicKey' => getenv('PLATIONLINE_PUBLIC_KEY'),
            'privateKey' => getenv('PLATIONLINE_PRIVATE_KEY'),
            'website' => getenv('PLATIONLINE_WEBSITE'),
            'initialVector' => getenv('PLATIONLINE_INITIAL_VECTOR'),
            'initialVectorItsn' => getenv('PLATIONLINE_INITIAL_VECTOR_ITSN'),
            'testMode' => true
        ];
    }
}
