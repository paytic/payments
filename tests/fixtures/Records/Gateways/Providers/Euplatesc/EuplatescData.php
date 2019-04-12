<?php

namespace ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Euplatesc;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class EuplatescData
 * @package ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Euplatesc
 */
class EuplatescData
{
    /**
     * @return string
     */
    public static function getMethodOptions()
    {
        $data = 'a:2:{s:15:"payment_gateway";s:9:"euplatesc";s:9:"euplatesc";'.
            'a:2:{s:3:"mid";s:11:"'.getenv('EUPLATESC_MID').'";'.
            's:3:"key";s:40:"'.getenv('EUPLATESC_KEY').'";'
            .'}}';

        return $data;
    }

    /**
     * @return HttpRequest
     */
    public static function getCompletePurchaseRequest()
    {
        $httpRequest = new HttpRequest();

        $httpRequest->request->add([
            'amount' => '10.00',
            'curr' => 'RON',
            'invoice_id' => '24669',
            'ep_id' => '76B746EF9E40BEC9C8B5FB770C183B4F25E69A5C',
            'merch_id' => '44840981287',
            'action' => '0',
            'message' => 'Approved',
            'approval' => '457310',
            'timestamp' => '20160217143252',
            'nonce' => '30364e770f52f3480674f27ed3f8baa4',
            'fp_hash' => 'EE0741518710927424DF7802BC82E849',
            'lang' => 'ro',
        ]);

        return $httpRequest;
    }

    /**
     * @return HttpRequest
     */
    public static function getCompletePurchaseRequestError()
    {
        $httpRequest = new HttpRequest();

        $httpRequest->request->add([
            'amount' => '10.00',
            'curr' => 'RON',
            'invoice_id' => '24677',
            'ep_id' => 'C4A9E42575AE6A1B8CF16811BAD41BB9065D7BBC',
            'merch_id' => '44840981287',
            'action' => '3',
            'message' => 'Authentication failed',
            'approval' => '',
            'timestamp' => '20160217154530',
            'nonce' => '1fc0444aeb5d304be6c7010f98ff5383',
            'fp_hash' => '0063140751D2F6235732F51E3EE74718',
            'lang' => 'ro',
        ]);

        return $httpRequest;
    }

    /**
     * @return HttpRequest
     */
    public static function getServerCompletePurchaseRequest()
    {
        $httpRequest = new HttpRequest();

        $httpRequest->request->add([
            'amount' => '10.00',
            'curr' => 'RON',
            'invoice_id' => '24669',
            'ep_id' => '76B746EF9E40BEC9C8B5FB770C183B4F25E69A5C',
            'merch_id' => '44840981287',
            'action' => '0',
            'message' => 'Approved',
            'approval' => '457310',
            'timestamp' => '20160217143252',
            'nonce' => '30364e770f52f3480674f27ed3f8baa4',
            'fp_hash' => 'EE0741518710927424DF7802BC82E849',
            'lang' => 'ro',
        ]);

        return $httpRequest;
    }
}
