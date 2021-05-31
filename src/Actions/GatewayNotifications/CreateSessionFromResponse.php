<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Class CreateSessionFromResponse
 * @package ByTIC\Payments\Actions\GatewayNotifications
 * @internal
 */
class CreateSessionFromResponse
{
    /**
     * @param NotificationData $notification
     * @return \ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionTrait
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