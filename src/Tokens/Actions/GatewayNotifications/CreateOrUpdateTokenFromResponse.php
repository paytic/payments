<?php

namespace Paytic\Payments\Tokens\Actions\GatewayNotifications;

use Nip\Records\AbstractModels\Record;
use Paytic\Omnipay\Common\Models\TokenInterface;
use Paytic\Payments\Actions\GatewayNotifications\NotificationData;
use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class CreateOrUpdateTokenFromResponse
 * @package Paytic\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateOrUpdateTokenFromResponse
{
    protected NotificationData $notification;

    /**
     * @param NotificationData $notification
     */
    public function __construct(NotificationData $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param NotificationData $notification
     * @return TransactionTrait|Record
     */
    public static function handle(NotificationData $notification)
    {
        return (new self($notification))->execute();
    }

    /**
     * @return Token|null
     */
    public function execute()
    {
        if (false === $this->hasValidToken()) {
            return null;
        }

        $this->notification->token = $this->createToken();
        $this->updateTransactionWithToken($this->notification->token);
        return $this->notification->token;
    }

    protected function hasValidToken(): bool
    {
        if (!method_exists($this->notification->response, 'getToken')) {
            return false;
        }

        $token = $this->notification->response->getToken();
        if (!($token instanceof TokenInterface)) {
            return false;
        }

        if (empty($token->getId())) {
            return false;
        }

        return true;
    }

    /**
     * @return Token
     */
    protected function createToken()
    {
        $token = $this->notification->response->getToken();
        $tokenModel = PaymentsModels::tokens()
            ->findOrCreateForMethod($this->notification->purchase->getPaymentMethod(), $token);
        $tokenModel->populateFromCustomer($this->notification->purchase->getPurchaseBillingRecord());
        $tokenModel->update();
        return $tokenModel;
    }

    /**
     * @param Token $token
     * @return void
     */
    protected function updateTransactionWithToken($token): void
    {
        $transaction = $this->notification->getOrFindTransaction();
        $transaction->populateFromToken($token);
        $transaction->update();
    }
}
