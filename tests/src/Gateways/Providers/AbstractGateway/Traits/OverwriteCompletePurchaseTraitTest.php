<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Traits;

use ByTIC\Payments\Mobilpay\Gateway as MobilpayGateway;
use ByTIC\Payments\Mobilpay\Message\CompletePurchaseRequest as MobilpayCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\Paylike\Gateway as PaylikeGateway;
use ByTIC\Omnipay\Paylike\Message\CompletePurchaseRequest as PaylikeCompletePurchaseRequest;
use ByTIC\Payments\Tests\AbstractTest;

/**
 * Class OverwriteCompletePurchaseTraitTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Traits
 */
class OverwriteCompletePurchaseTraitTest extends AbstractTest
{
    public function test_completePurchase_internal_check()
    {
        $mobilpay = new MobilpayGateway();
        $request = $mobilpay->completePurchase();
        self::assertInstanceOf(MobilpayCompletePurchaseRequest::class, $request);

        $paylike = new PaylikeGateway();
        $request = $paylike->completePurchase();
        self::assertInstanceOf(PaylikeCompletePurchaseRequest::class, $request);
    }
}
