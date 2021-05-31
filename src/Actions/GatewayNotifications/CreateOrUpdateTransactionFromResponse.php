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
        static::updateTransaction($notification->response, $notification->transaction);
        return $notification->transaction;
    }


    /**
     * @param AbstractResponse|ServerCompletePurchaseResponse $response
     * @param $transaction
     */
    protected static function updateTransaction(AbstractResponse $response, $transaction)
    {
        static::setPropertyFromResponse($response, $transaction, 'getCode', 'code');
        static::setPropertyFromResponse($response, $transaction, 'getTransactionReference', 'reference');
        static::setPropertyFromResponse($response, $transaction, 'getCardMasked', 'card');

        $transaction->update();
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