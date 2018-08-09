<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Librapay;

use ByTIC\Payments\Gateways\Providers\Librapay\Helper;
use ByTIC\Payments\Tests\AbstractTest;

/**
 * Class HelperTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\Librapay
 */
class HelperTest extends AbstractTest
{
    public function testEncodeOrderId()
    {
        self::assertEquals(
            9999999999999900089,
            Helper::encodeOrderId(89)
        );

        $testEncoded = Helper::encodeOrderId(44213);
        self::assertEquals(
            9999999999999944213,
            $testEncoded
        );
        self::assertEquals(
            19,
            strlen($testEncoded)
        );
    }

    public function testDecodeOrderId()
    {
        self::assertEquals(
            89,
            Helper::decodeOrderId('9999999999999900089')
        );
    }
}
