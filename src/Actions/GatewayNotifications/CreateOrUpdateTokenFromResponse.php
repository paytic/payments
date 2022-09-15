<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Nip\Records\AbstractModels\Record;
use Paytic\Omnipay\Common\Models\TokenInterface;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class CreateOrUpdateTokenFromResponse
 * @package Paytic\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateOrUpdateTokenFromResponse
{
    /**
     * @param NotificationData $notification
     * @return TransactionTrait|Record
     */
    public static function handle(NotificationData $notification)
    {
        if (!method_exists($notification->response, 'getToken')) {
            return null;
        }

        $token = $notification->response->getToken();
        if (!($token instanceof TokenInterface)) {
            return null;
        }

        if (empty($token->getId())) {
            return null;
        }

        $notification->token = PaymentsModels::tokens()
            ->findOrCreateForMethod($notification->purchase->getPaymentMethod(), $token);
        $notification->token->populateFromCustomer($notification->purchase->getPurchaseBillingRecord());
        $notification->token->update();

        return $notification->token;
    }
}
