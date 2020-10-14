<?php

namespace ByTIC\Payments\Gateways\Providers\PlatiOnline\Message;

use ByTIC\Omnipay\PlatiOnline\Message\ServerCompletePurchaseResponse as AbstractServerCompletePurchaseResponse;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;

/**
 * Class ServerCompletePurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\PlatiOnline\Message
 */
class ServerCompletePurchaseResponse extends AbstractServerCompletePurchaseResponse
{
    use CompletePurchaseResponseTrait;

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return bool
     */
    protected function canProcessModel()
    {
        return true;
    }

    /**
     * @return []
     */
    public function getSessionDebug()
    {
        $notification = $this->getNotification();
        $objJsonDocument = json_encode($notification);
        return json_decode($objJsonDocument, TRUE);
    }
}
