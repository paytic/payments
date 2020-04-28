<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Mobilpay\Message;

use ByTIC\Payments\Gateways\Providers\Mobilpay\Message\CompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\Mobilpay\Message\CompletePurchaseResponse;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecord;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecordManager;
use ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message\CompletePurchaseResponseTestTrait;
use Symfony\Component\HttpFoundation\Request;

class CompletePurchaseResponseTest extends AbstractTest
{
    use CompletePurchaseResponseTestTrait;

    public function testResponseForValidTransaction()
    {
        $httpRequest = $this->generateRequestFromFixtures(
            TEST_FIXTURE_PATH . '/requests/mobilpay/completePurchase/basicParams.php'
        );

        $model = \Mockery::mock(PurchasableRecord::class)->makePartial();
        $model->shouldReceive('getPaymentGateway')->andReturn(null);

        $modelManager = \Mockery::mock(PurchasableRecordManager::class)->makePartial();
        $modelManager->shouldReceive('findOne')->andReturn($model);

        $request = new CompletePurchaseRequest($this->client, $httpRequest);
        $request->setModelManager($modelManager);

        $response = $request->send();
        self::assertInstanceOf(CompletePurchaseResponse::class, $response);
        self::assertSame(false, $response->isCancelled());
        self::assertSame(true, $response->isPending());
        self::assertSame('pending', $response->getModelResponseStatus());

//        $content = $response->getViewContent();
//
//        self::assertStringContainsString('++++', $content);
    }

    protected function getNewResponse()
    {
        $request = new CompletePurchaseRequest($this->client, new Request());

        return new CompletePurchaseResponse($request, []);
    }
}
