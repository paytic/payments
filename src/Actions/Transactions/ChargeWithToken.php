<?php

namespace Paytic\Payments\Actions\Transactions;

use Omnipay\Common\Message\AbstractResponse;
use Paytic\Payments\Actions\GatewayNotifications\UpdatePaymentModelsFromResponse;
use Paytic\Payments\Exception\RequestNotSupportedException;
use Paytic\Payments\Models\Transactions\Transaction;

/**
 * Class ChargeWithToken
 * @package Paytic\Payments\Actions\Transactions
 */
class ChargeWithToken
{
    /**
     * @param Transaction $transaction
     */
    public static function process($transaction)
    {
        $purchase = $transaction->getPurchase();
        $method = $transaction->getPaymentMethod();
        $gateway = $method->getGateway();

        if (!method_exists($gateway, 'purchaseWithToken')) {
            throw RequestNotSupportedException::create('purchaseWithToken', $gateway);
        }

        $parameters = $purchase->getPurchaseParameters();
        $parameters['token'] = $transaction->getToken()->getTokenId();

        /** @var AbstractResponse $response */
        $response = $gateway->purchaseWithToken($parameters);

        $response->processModel();
        UpdatePaymentModelsFromResponse::handle($response, $model, 'IPN');

        return $response;
    }
}
