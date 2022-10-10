<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Nip\Records\AbstractModels\Record;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\TransactionTrait;

/**
 * Class CreateOrUpdateTransactionFromResponse
 * @package Paytic\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateOrUpdateTransactionFromResponse
{
    protected NotificationData $notification;
    protected Transaction $transaction;

    /**
     * @param NotificationData $notification
     */
    public function __construct(NotificationData $notification)
    {
        $this->notification = $notification;
        $this->transaction = $notification->getOrFindTransaction();
    }

    /**
     * @param $response
     * @param $model
     * @param $type
     * @return TransactionTrait|Record
     */
    public static function handle(NotificationData $notification)
    {
        return (new self($notification))->execute();
    }

    /**
     * @return Transaction|TransactionTrait|null
     */
    public function execute()
    {
        $this->updateFromResponse();
        $this->transaction->status = $this->notification->purchase->getStatus();
        $this->transaction->update();

        return $this->transaction;
    }


    /**
     */
    protected function updateFromResponse(): void
    {
        $this->setPropertyFromResponse('getCode', 'code');
        $this->setPropertyFromResponse('getTransactionReference', 'reference');
        $this->setPropertyFromResponse('getCardMasked', 'card');
    }

    /**
     * @param $method
     * @param $property
     */
    protected function setPropertyFromResponse($method, $property): void
    {
        $response = $this->notification->response;
        if (!method_exists($response, $method)) {
            return;
        }
        $value = $response->{$method}();
        if ($value === null || $value === '') {
            return;
        }
        $this->transaction->{$property} = $value;
    }
}
