<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Omnipay\Common\Message\AbstractResponse;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelProcessedResponse;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\PurchaseSessions\Models\PurchaseSessionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class NotificationData
 * @package Paytic\Payments\Actions\GatewayNotifications
 */
class NotificationData
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var AbstractResponse|HasModelProcessedResponse
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
     * @param HasModelProcessedResponse|AbstractResponse $response
     * @param IsPurchasableModelTrait $purchase
     */
    public function __construct(string $type, $response, $purchase)
    {
        $this->type = $type;
        $this->response = $response;
        $this->purchase = $purchase;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return Transaction|TransactionTrait|null
     */
    public function getOrFindTransaction()
    {
        if (isset($this->transaction)) {
            return $this->transaction;
        }

        $this->transaction = PaymentsModels::transactions()
            ->findOrCreateForPurchase($this->purchase);
        return $this->transaction;
    }
}
