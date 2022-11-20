<?php

namespace Paytic\Payments\Tests\Models\Purchases;

use Paytic\Payments\Tests\AbstractTestCase;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class PurchasesTest
 * @package Paytic\Payments\Tests\Models\Purchases
 */
class PurchaseTest extends AbstractTestCase
{
    public function test_getEmptyStatus()
    {
        $purchasesRepository = $this->initUtilityModel(PaymentsModels::PURCHASES);
        $purchase = $purchasesRepository->getNew();

        self::assertSame(null, $purchase->getPropertyRaw('status'));
        self::assertSame('pending', (string)$purchase->getStatus());
    }


}
