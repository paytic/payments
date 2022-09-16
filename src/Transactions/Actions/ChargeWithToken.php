<?php

namespace Paytic\Payments\Transactions\Actions;

use Omnipay\Common\Message\AbstractResponse;
use Paytic\Payments\Actions\GatewayNotifications\UpdatePaymentModelsFromResponse;
use Paytic\Payments\Exception\InvalidArgumentException;
use Paytic\Payments\Exception\RequestNotSupportedException;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Paytic\Payments\Models\Transactions\Transaction;

/**
 * Class ChargeWithToken
 * @package Paytic\Payments\Actions\Transactions
 */
class ChargeWithToken
{
    protected Transaction $transaction;
    protected $purchase;

    /**
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @param Transaction $transaction
     */
    public static function process($transaction)
    {
        return (new self($transaction))->execute();
    }

    protected function execute(): AbstractResponse
    {
        $this->purchase = $this->transaction->getPurchase();

        $gateway = $this->determineGateway();
        $parameters = $this->determineParameters();

        /** @var AbstractResponse $response */
        $response = $gateway->purchaseWithToken($parameters);

        $response->processModel();
        UpdatePaymentModelsFromResponse::handle($response, $this->transaction, 'IPN');

        return $response;
    }

    protected function determineGateway(): bool|GatewayTrait|null
    {
        $method = $this->transaction->getPaymentMethod();
        if (!is_object($method)) {
            throw new InvalidArgumentException("No payment method found for Transaction ID:" . $this->transaction->id);
        }
        $gateway = $method->getGateway();

        if (!method_exists($gateway, 'purchaseWithToken')) {
            throw RequestNotSupportedException::create('purchaseWithToken', $gateway);
        }
        return $gateway;
    }

    /**
     * @return mixed
     */
    protected function determineParameters()
    {
        $parameters = $this->purchase->getPurchaseParameters();
        $parameters['token'] = $this->transaction->getToken()->getTokenId();
        return $parameters;
    }
}