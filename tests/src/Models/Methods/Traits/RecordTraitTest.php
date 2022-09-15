<?php

namespace Paytic\Payments\Tests\Models\Methods\Traits;

use Paytic\Payments\Mobilpay\Gateway as MobilpayGateway;
use Paytic\Payments\Euplatesc\Gateway as EuplatescGateway;
use Paytic\Payments\Models\Methods\Types\BankTransfer;
use Paytic\Payments\Models\Methods\Types\Cash;
use Paytic\Payments\Models\Methods\Types\CreditCards;
use Paytic\Payments\Models\Methods\Types\Waiver;
use Paytic\Payments\Tests\AbstractTest;
use Paytic\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;

/**
 * Class RecordTraitTest
 * @package Paytic\Payments\Tests\Models\Methods\Traits
 */
class RecordTraitTest extends AbstractTest
{

    /**
     * @dataProvider data_getType
     *
     * @param $type
     * @param $class
     */
    public function test_getType($type, $class)
    {
        $method = new PaymentMethod();
        $method->type = $type;

        self::assertInstanceOf($class, $method->getType());
    }

    /**
     * @return array
     */
    public function data_getType()
    {
        return [
            ['bank-transfer', BankTransfer::class],
            ['cash', Cash::class],
            ['credit-cards', CreditCards::class],
            ['waiver', Waiver::class],
        ];
    }


    /**
     * @dataProvider data_getType_gateways
     *
     * @param $type
     * @param $class
     * @param $gateway
     */
    public function test_getType_gateways($type, $class, $gateway)
    {
        $method = new PaymentMethod();
        $method->type = $type;

        self::assertInstanceOf($class, $method->getType());
        self::assertSame($type, $method->getType()->getGatewayName());
    }

    /**
     * @return array
     */
    public function data_getType_gateways()
    {
        return [
            ['mobilpay', CreditCards::class, MobilpayGateway::class],
            ['euplatesc', CreditCards::class, EuplatescGateway::class]
        ];
    }
}
