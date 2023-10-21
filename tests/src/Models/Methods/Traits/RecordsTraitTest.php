<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Methods\Traits;

use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Methods\Types\BankTransfer;
use Paytic\Payments\Models\Methods\Types\CardPresent;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class RecordTraitTest.
 */
class RecordsTraitTest extends AbstractTest
{
    /**
     */
    public function test_getTypes()
    {
        $repository = new PaymentMethods();
        $types = $repository->getTypes();

        self::assertCount(6, $types);
        self::assertInstanceOf(BankTransfer::class, $types[BankTransfer::NAME]);
        self::assertInstanceOf(CardPresent::class, $types[CardPresent::NAME]);
        self::assertInstanceOf(BankTransfer::class, $types[BankTransfer::NAME]);
    }

}
