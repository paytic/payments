<?php

namespace Paytic\Payments\Transactions\Actions;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractResponse;
use Paytic\Payments\Actions\GatewayNotifications\UpdatePaymentModelsFromResponse;
use Paytic\Payments\Exception\InvalidArgumentException;
use Paytic\Payments\Exception\RequestNotSupportedException;
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
        $this->purchase = $this->transaction->getPurchase();
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
        $response = $this->sendRequest();
        $this->processReponse($response);

        return $response;
    }

    protected function sendRequest(): AbstractResponse
    {
        $gateway = $this->determineGateway();
        $parameters = $this->determineParameters();

        $request = $gateway->purchaseWithToken($parameters);
        /** @var AbstractResponse $response */
        $response = $request->send();
        $response->processModel();

        return $response;
    }

    protected function processReponse($response)
    {
        $action = UpdatePaymentModelsFromResponse::createFor($response, $this->purchase, 'TOKEN');
        $action->withTransaction($this->transaction);
        $action->process();
    }

    /**
     * @return bool|AbstractGateway|null
     */
    protected function determineGateway(): bool|AbstractGateway|null
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
        $parameters['model'] = $this->purchase;
        return $parameters;
    }
}
