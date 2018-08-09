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
            $idOrder = '9999999999999'.str_pad($idOrder, 5, "0", STR_PAD_LEFT);
        }

        return $idOrder;
    }

    /**
     * @param $idOrder
     * @return int
     */
    public static function decodeOrderId($idOrder)
    {
        $idString = (string) $idOrder;
        if (strlen($idString) == 18) {
            $idOrder = str_replace('9999999999999', '', $idString);
        }
        return $idOrder;
    }
}