<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Purchases;

use Paytic\Payments\Tests\AbstractTestCase;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class PurchasesTest.
 */
class PurchaseTest extends AbstractTestCase
{
    public function testGetEmptyStatus()
    {
        $purchasesRepository = $this->initUtilityModel(PaymentsModels::PURCHASES);
        $purchase = $purchasesRepository->getNew();

        self::assertNull($purchase->getPropertyRaw('status'));
        self::assertSame('pending', (string)$purchase->getStatus());
    }
}
