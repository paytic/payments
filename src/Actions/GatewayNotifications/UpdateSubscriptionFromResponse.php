<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

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
        if (!is_object($notification->token)) {
            return null;
        }

        $notification->subscription = $notification->transaction->getSubscription();
        $notification->subscription->populateFromToken($notification->token);
        $notification->subscription->update();

        return $notification->subscription;
    }
}