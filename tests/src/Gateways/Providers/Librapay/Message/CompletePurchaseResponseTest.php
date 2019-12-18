<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Librapay\Message;

use ByTIC\Payments\Gateways\Providers\Librapay\Message\CompletePurchaseResponse;
use ByTIC\Payments\Gateways\Providers\Librapay\Message\CompletePurchaseRequest;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecord;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecordManager;
use ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message\CompletePurchaseResponseTestTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CompletePurchaseResponseTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\Librapay\Message
 */
class CompletePurchaseResponseTest extends AbstractTest
{
    use CompletePurchaseResponseTestTrait;

//    public function testSend()
//    {
//        $httpRequest = $this->generateRequestFromFixtures(
//            TEST_FIXTURE_PATH . '/requests/librapay/completePurchaseParams2.php'
//        );
//
//        $model = \Mockery::mock(PurchasableRecord::class)->makePartial();
//        $model->shouldReceive('getPaymentGateway')->andReturn(null);
//
//        $modelManager = \Mockery::mock(PurchasableRecordManager::class)->makePartial();
//        $modelManager->shouldReceive('findOne')->andReturn($model);
//
//        $request = new CompletePurchaseRequest($this->client, $httpRequest);
//        $request->setModelManager($modelManager);
//
//        $response = $request->send();
//
//        self::assertInstanceOf(CompletePurchaseResponse::class, $response);
//    }

    /**
     * @return CompletePurchaseResponse
     */
    protected function getNewResponse()
    {
        $request = new CompletePurchaseRequest($this->client, new Request());

        return new CompletePurchaseResponse($request, []);
    }
}
