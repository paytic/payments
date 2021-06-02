<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

use ByTIC\Omnipay\Common\Models\TokenInterface;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Class CreateOrUpdateTokenFromResponse
 * @package ByTIC\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateOrUpdateTokenFromResponse
{
    /**
     * @param NotificationData $notification
     * @return \ByTIC\Payments\Models\Transactions\TransactionTrait|\Nip\Records\AbstractModels\Record
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