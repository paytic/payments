<?php

namespace Paytic\Payments\Utility;

/**
 * Class FeeCalculator
 * @package Paytic\Payments\Utility
 */
class FeeCalculator
{
    /**
     * @param $amount
     * @param $percentage
     * @param $fixed
     */
    public static function netToGross($amount, $percentage, $fixed = 0)
    {
        $result = ($amount + $fixed) / (1 - $percentage / 100);
        return round($result, 1);
    }
}
