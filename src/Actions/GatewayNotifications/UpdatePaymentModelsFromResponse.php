<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Bytic\Actions\Action;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Tokens\Actions\GatewayNotifications\CreateOrUpdateTokenFromResponse;

/**
 * Class UpdatePaymentModelsFromResponse
 * @package Paytic\Payments\Actions
 * @internal
 */
class UpdatePaymentModelsFromResponse extends Action
{
    protected NotificationData $notification;

    protected function __construct(NotificationData $notification)
    {
        $this->notification = $notification;
    }

    public static function createFor($response, $model, $type)
    {
        $notification = new NotificationData($type, $response, $model);
        return new static($notification);
    }

    public function withTransaction(Transaction $transaction)
    {
        $this->notification->setTransaction($transaction);
        return $this;
    }

    /**
     * @param $response
     * @param $model
     * @param string $type
     * @deprecated use createFor
     */
    public static function handle($response, $model, $type)
    {
        self::createFor($response, $model, $type)->process();
    }

    public function process(): void
    {
        CreateSessionFromResponse::handle($this->notification);
        CreateOrUpdateTransactionFromResponse::handle($this->notification);
        CreateOrUpdateTokenFromResponse::handle($this->notification);
        UpdateSubscriptionFromResponse::handle($this->notification);
    }
}
