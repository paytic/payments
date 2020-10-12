<?php

namespace ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Librapay;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

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
        $data = 'a:2:{s:15:"payment_gateway";s:8:"librapay";s:8:"librapay";a:7:{s:7:"sandbox";s:2:"no";s:8:"merchant";s:15:"'.getenv('LIBRAPAY_MERCHANT').'";s:12:"merchantName";s:36:"'.getenv('LIBRAPAY_MERCHANTNAME').'";s:13:"merchantEmail";s:17:"'.getenv('LIBRAPAY_MERCHANTEMAIL').'";s:11:"merchantUrl";s:16:"register.42km.ro";s:8:"terminal";s:8:"'.getenv('LIBRAPAY_TERMINAL').'";s:3:"key";s:32:"'.getenv('LIBRAPAY_KEY').'";}}';
        return $data;
    }

    /**
     * @return HttpRequest
     */
    public static function getServerCompletePurchaseRequest()
    {
        $httpRequest = new HttpRequest();

        $httpRequest->query->add(['hash' => "2fe4c45ebabc6f90b826180e67840f411f81e8e0"]);

        $post = [
            'AMOUNT' => 50.00,
            'CURRENCY' => 'RON',
            'ORDER' => 172490,
            'DESC' => 'Plata RUN IOR - 17 oct 2020 [#1602436479-343556]',
            'MERCH_NAME' => '',
            'MERCH_URL' => '',
            'MERCHANT' => '',
            'TERMINAL' => '88002369',
            'EMAIL' => '',
            'TRTYPE' => 0,
            'COUNTRY' => '',
            'MERCH_GMT' => '',
            'ACTION' => 0,
            'TIMESTAMP' => 20201011171601,
            'RC' => '00',
            'MESSAGE' => 'Approved',
            'RRN' => '028584881920',
            'INT_REF' => '1111',
            'APPROVAL' => '1111',
            'NONCE' => 'c3c18b5fce9ea177def8f1433630449b',
            'SO' => '',
            'P_SIGN' => '4348995B1491E5DA26337C7E331EF40199FF28FF'
        ];
        $httpRequest->request->add($post);

        return $httpRequest;
    }
}
