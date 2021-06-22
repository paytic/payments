<?php

namespace ByTIC\Payments\Actions\Transactions;

use ByTIC\Payments\Actions\GatewayNotifications\UpdatePaymentModelsFromResponse;
use ByTIC\Payments\Exception\RequestNotSupportedException;
use ByTIC\Payments\Models\Transactions\Transaction;
use Omnipay\Common\Message\AbstractResponse;

/**
 * Class ChargeWithToken
 * @package ByTIC\Payments\Actions\Transactions
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
