<?php

namespace ByTIC\Payments\Tests\Models\Methods\Traits;

use ByTIC\Payments\Models\Methods\Types\BankTransfer;
use ByTIC\Payments\Models\Methods\Types\Cash;
use ByTIC\Payments\Models\Methods\Types\CreditCards;
use ByTIC\Payments\Models\Methods\Types\Waiver;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;

/**
 * Class RecordTraitTest
 * @package ByTIC\Payments\Tests\Models\Methods\Traits
 */
class RecordTraitTest extends AbstractTest
{

    /**
     * @dataProvider dataGetType
     *
     * @param $type
     * @param $class
     */
    public function testGetType($type, $class)
    {
        $method       = new PaymentMethod();
        $method->type = $type;

        self::assertInstanceOf($class, $method->getType());
    }

    /**
     * @return array
     */
    public function dataGetType()
    {
        return [
            ['bank-transfer', BankTransfer::class],
            ['cash', Cash::class],
            ['credit-cards', CreditCards::class],
            ['waiver', Waiver::class],
        ];
    }
}