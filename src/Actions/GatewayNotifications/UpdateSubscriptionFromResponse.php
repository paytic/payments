<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

use ByTIC\Payments\Actions\Subscriptions\UpdateFromTransactionNotification;

/**
 * Class UpdateSubscriptionFromResponse
 * @package ByTIC\Payments\Actions\GatewayNotifications
 * @internal
 */
class UpdateSubscriptionFromResponse
{
    /**
     * @param NotificationData $notification
     * @return \ByTIC\Payments\Models\Transactions\TransactionTrait|\Nip\Records\AbstractModels\Record
     */
    public static function handle(NotificationData $notification)
    {
        if (!is_object($notification->transaction) || $notification->transaction->isSubscription() !== true) {
            return null;
        }
        $notification->subscription = $notification->transaction->getSubscription();

        if (is_object($notification->token)) {
            $notification->subscription->populateFromToken($notification->token);
        }
        $notification->subscription->update();

        UpdateFromTransactionNotification::handle($notification->subscription, $notification->transaction);

        return $notification->subscription;
    }
}
