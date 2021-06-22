<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelProcessedResponse;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionTrait;
use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Models\Tokens\Token;
use ByTIC\Payments\Models\Transactions\Transaction;

/**
 * Class NotificationData
 * @package ByTIC\Payments\Actions\GatewayNotifications
 */
class NotificationData
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var \Omnipay\Common\Message\AbstractResponse|HasModelProcessedResponse
     */
    public $response;

    /**
     * @var IsPurchasableModelTrait
     */
    public $purchase;

    /**
     * @var PurchaseSessionTrait
     */
    public $session;

    /**
     * @var Token|null
     */
    public $token = null;

    /**
     * @var Transaction|null
     */
    public $transaction = null;

    /**
     * @var Subscription|null
     */
    public $subscription = null;

    /**
     * NotificationData constructor.
     * @param string $type
     * @param HasModelProcessedResponse|\Omnipay\Common\Message\AbstractResponse $response
     * @param IsPurchasableModelTrait $purchase
     */
    public function __construct(string $type, $response, $purchase)
    {
        $this->type = $type;
        $this->response = $response;
        $this->purchase = $purchase;
    }
}
