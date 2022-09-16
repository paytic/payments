<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Nip\Records\AbstractModels\Record;
use Paytic\Payments\Models\Transactions\TransactionTrait;
use Paytic\Payments\Subscriptions\Actions\UpdateFromTransactionNotification;

/**
 * Class UpdateSubscriptionFromResponse
 * @package Paytic\Payments\Actions\GatewayNotifications
 * @internal
 */
class UpdateSubscriptionFromResponse
{
    /**
     * @param NotificationData $notification
     * @return TransactionTrait|Record
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
