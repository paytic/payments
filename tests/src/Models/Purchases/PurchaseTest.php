<?php

namespace Paytic\Payments\Tests\Models\Purchases;

use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class PurchasesTest
 * @package Paytic\Payments\Tests\Models\Purchases
 */
class PurchaseTest extends AbstractTestCase
{
    public function test_getEmptyStatus()
    {
        $purchasesRepository = $this->initUtilityModel('purchases');
        $purchase = $purchasesRepository->getNew();

        self::assertSame(null, $purchase->getPropertyRaw('status'));
        self::assertSame('pending', (string)$purchase->getStatus());
    }


}
