<?php

namespace ByTIC\Payments\Gateways\Providers\Librapay;

/**
 * Class Helper
 * @package ByTIC\Payments\Gateways\Providers\Librapay
 */
class Helper
{
    /**
     * Required because librapay API needs order id at least 6 digits no leading zero
     * @param $idOrder
     * @return mixed
     */
    public static function encodeOrderId($idOrder)
    {
        if ($idOrder < 100000) {
            $idOrder = 9999999999999900000 + $idOrder;
        }

        return $idOrder;
    }

    /**
     * @param $idOrder
     * @return int
     */
    public static function decodeOrderId($idOrder)
    {
        if (strlen($idOrder) == 19 && $idOrder > 9999999999999900000) {
            $idOrder = $idOrder - 9999999999999900000;
        }

        return $idOrder;
    }
}