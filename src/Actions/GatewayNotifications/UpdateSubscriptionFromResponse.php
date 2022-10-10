<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Nip\Records\AbstractModels\Record;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\GatewayNotifications\OnTransactionNotification;

/**
 * Class UpdateSubscriptionFromResponse
 * @package Paytic\Payments\Actions\GatewayNotifications
 * @internal
 */
class UpdateSubscriptionFromResponse
{
    /**
     * @param NotificationData $notification
     * @return Subscription|Record
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

        OnTransactionNotification::handle($notification->subscription, $notification->transaction);

        return $notification->subscription;
    }
}
