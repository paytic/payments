<?php

namespace ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Librapay;

/**
 * Class LibrapayData
 * @package ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Librapay
 */
class LibrapayData
{
    /**
     * @return string
     */
    public static function getMethodOptions()
    {
        $data = 'a:2:{s:15:"payment_gateway";s:8:"librapay";s:8:"librapay";'.
            'a:2:{s:3:"mid";s:11:"'.getenv('EUPLATESC_MID').'";'.
            's:3:"key";s:40:"'.getenv('EUPLATESC_KEY').'";'
            .'}}';

        return $data;
    }

}