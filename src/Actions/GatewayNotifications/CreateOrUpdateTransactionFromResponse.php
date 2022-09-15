<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use ByTIC\Omnipay\Librapay\Message\ServerCompletePurchaseResponse;
use Nip\Records\AbstractModels\Record;
use Omnipay\Common\Message\AbstractResponse;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class CreateOrUpdateTransactionFromResponse
 * @package Paytic\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateOrUpdateTransactionFromResponse
{
    /**
     * @param $response
     * @param $model
     * @param $type
     * @return TransactionTrait|Record
     */
    public static function handle(NotificationData $notification)
    {
        $notification->transaction = PaymentsModels::transactions()->findOrCreateForPurchase($notification->purchase);

        static::updateFromResponse($notification->response, $notification->transaction);
        $notification->transaction->status = $notification->purchase->getStatus();

        $notification->transaction->update();

        return $notification->transaction;
    }


    /**
     * @param AbstractResponse|ServerCompletePurchaseResponse $response
     * @param $transaction
     */
    protected static function updateFromResponse(AbstractResponse $response, $transaction)
    {
        static::setPropertyFromResponse($response, $transaction, 'getCode', 'code');
        static::setPropertyFromResponse($response, $transaction, 'getTransactionReference', 'reference');
        static::setPropertyFromResponse($response, $transaction, 'getCardMasked', 'card');
    }

    /**
     * @param $response
     * @param $transaction
     * @param $method
     * @param $property
     */
    protected static function setPropertyFromResponse($response, $transaction, $method, $property)
    {
        if (!method_exists($response, $method)) {
            return;
        }
        $value = $response->{$method}();
        if ($value === null || $value === '') {
            return;
        }
        $transaction->{$property} = $value;
    }
}
