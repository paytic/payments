<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Utility;

use Paytic\Payments\Tests\AbstractTest;
use Paytic\Payments\Utility\FeeCalculator;

/**
 * Class FeeCalculatorTest.
 */
class FeeCalculatorTest extends AbstractTest
{
    /**
     * @dataProvider data_netToGross
     */
    public function testNetToGross($net, $gross, $percentage, $fixed)
    {
        $diff = abs($gross - FeeCalculator::netToGross($net, $percentage, $fixed));
        self::assertLessThan(1, $diff);
    }

    public function data_netToGross()
    {
        return [
            [29.4, 30, 0.99, 0.3],
            [148.21, 150, 0, 0.99, 0.3],
        ];
    }
}
