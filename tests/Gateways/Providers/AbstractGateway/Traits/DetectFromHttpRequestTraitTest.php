<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Traits;

use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\PurchasableRecord;
use ByTIC\Payments\Tests\Fixtures\Records\PurchasableRecordManager;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class DetectFromHttpRequestTraitTest extends AbstractTest
{

    /**
     * @dataProvider dataGetRequestFromHttpRequest
     */
    public function testGetRequestFromHttpRequestRomcard($gateway, $requestClass)
    {
        $httpRequest = HttpRequest::createFromGlobals();
        $parameters = require TEST_FIXTURE_PATH . '/requests/' . $gateway . '/completePurchaseParams.php';

        $httpRequest->query->replace(isset($parameters['GET']) ? $parameters['GET'] : []);
        $httpRequest->request->replace(isset($parameters['POST']) ? $parameters['POST'] : []);


        $model = \Mockery::mock(PurchasableRecord::class)->makePartial();
        $model->shouldReceive('getPaymentGateway')->andReturn(null);

        $modelManager = \Mockery::mock(PurchasableRecordManager::class)->makePartial();
        $modelManager->shouldReceive('findOne')->andReturn($model);

        $request = Manager::getRequestFromHttpRequest($modelManager, null, $httpRequest);
        self::assertInstanceOf($requestClass, $request);
    }

    public function dataGetRequestFromHttpRequest()
    {
        return [
            ['librapay', \ByTIC\Payments\Gateways\Providers\Librapay\Message\CompletePurchaseRequest::class],
            ['romcard', \ByTIC\Payments\Gateways\Providers\Romcard\Message\CompletePurchaseRequest::class]
        ];
    }
}