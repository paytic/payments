<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway;

use ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Gateway;
use Omnipay\Common\Message\AbstractRequest;
use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Models\Methods\Types\CreditCards;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\BillingRecord;
use ByTIC\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;
use ByTIC\Payments\Tests\Fixtures\Records\PurchasableRecord;
use ByTIC\Payments\Tests\Fixtures\Records\PurchasableRecordManager;
use Mockery as m;

/**
 * Class TraitsTest
 * @package ByTIC\Common\Tests\Unit\Payments\Providers\AbstractGateway
 */
abstract class GatewayTest extends AbstractTest
{
    /**
     * @var GatewaysManager
     */
    protected $gatewayManager;

    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var PurchasableRecord
     */
    protected $purchase;

    /**
     * @var PurchasableRecordManager
     */
    protected $purchaseManager;

    public function testServerCompletePurchase()
    {
        if (method_exists($this->gateway, 'serverCompletePurchase')) {
            $request = $this->gateway->serverCompletePurchase([]);
            self::assertInstanceOf(AbstractRequest::class, $request);
        } else {
            $request = $this->gateway->detectFromHttpRequestTrait($this->purchaseManager, 'serverCompletePurchase');
            self::assertSame(false, $request);
        }
    }

    protected function setUp()
    {
        parent::setUp();

        $this->purchase = $this->generatePurchaseMock();
        $this->purchase->shouldReceive('getName')->andReturn('Payment description');
        $this->setUpPurchaseManagerMock();

        $paymentMethod = new PaymentMethod();

        $type = new CreditCards();
        $type->setItem($paymentMethod);
        $paymentMethod->setType($type);

        $this->purchase->shouldReceive('getPaymentMethod')->andReturn($paymentMethod);

        $billing = new BillingRecord();
        $this->purchase->shouldReceive('getPurchaseBillingRecord')->andReturn($billing);

        $this->gatewayManager = new GatewaysManager();
    }

    /**
     * @return m\Mock
     */
    protected function generatePurchaseMock()
    {
        $purchase = m::mock(PurchasableRecord::class)->makePartial();

        return $purchase;
    }

    protected function setUpPurchaseManagerMock()
    {
        $this->purchaseManager = $this->generatePurchaseManagerMock($this->purchase);
        $this->purchase->setManager($this->purchaseManager);
    }

    /**
     * @param $purchase
     * @return m\Mock
     */
    protected function generatePurchaseManagerMock($purchase)
    {
        $purchaseManager = m::mock(PurchasableRecordManager::class)->makePartial();
        $purchaseManager->shouldReceive('findOne')->withArgs([37250])->andReturn($purchase);
        $purchaseManager->shouldReceive('findOne')->withArgs([24669])->andReturn($purchase);
        $purchaseManager->shouldReceive('findOne')->withArgs([24677])->andReturn($purchase);

        return $purchaseManager;
    }
}
