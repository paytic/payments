<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

use ByTIC\Omnipay\Librapay\Message\ServerCompletePurchaseResponse;
use ByTIC\Payments\Utility\PaymentsModels;
use Omnipay\Common\Message\AbstractResponse;

/**
 * Class CreateOrUpdateTransactionFromResponse
 * @package ByTIC\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateOrUpdateTransactionFromResponse
{
    /**
     * @param $response
     * @param $model
     * @param $type
     * @return \ByTIC\Payments\Models\Transactions\TransactionTrait|\Nip\Records\AbstractModels\Record
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