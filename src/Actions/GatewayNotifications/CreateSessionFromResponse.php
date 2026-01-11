<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Paytic\Payments\PurchaseSessions\Models\PurchaseSessionTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class CreateSessionFromResponse
 * @package Paytic\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateSessionFromResponse
{
    /**
     * @param NotificationData $notification
     * @return PurchaseSessionTrait
     */
    public static function handle(NotificationData $notification)
    {
        $sessions = PaymentsModels::sessions();

        $notification->session = $sessions->generateFromPurchaseType($notification->purchase, $notification->type);
        $notification->session->populateFromResponse($notification->response);
        $notification->session->insert();
        return $notification->session;
    }
}
