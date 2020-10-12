<?php

namespace ByTIC\Payments\Gateways\Providers\PlatiOnline\Message;

use ByTIC\Omnipay\PlatiOnline\Message\ServerCompletePurchaseRequest as AbstractServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;

/**
 * Class ServerCompletePurchaseRequest
 * @package ByTIC\Payments\Gateways\Providers\PlatiOnline\Message
 */
class ServerCompletePurchaseRequest extends AbstractServerCompletePurchaseRequest
{
    use HasModelRequest;
    use Traits\CompletePurchaseTrait;

    /**
     * @inheritDoc
     */
    protected function parseNotification()
    {
        $return = parent::parseNotification();
        if ($return->f_order_number) {
            $model = $this->findModel($return->f_order_number);
            if (is_object($model)) {
                $this->setModel($model);
            }
        }
        return $return;
    }
}
