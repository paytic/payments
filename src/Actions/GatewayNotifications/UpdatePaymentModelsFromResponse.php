<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

/**
 * Class UpdatePaymentModelsFromResponse
 * @package Paytic\Payments\Actions
 * @internal
 */
class UpdatePaymentModelsFromResponse
{
    /**
     * @param $response
     * @param $model
     * @param string $type
     */
    public static function handle($response, $model, $type)
    {
        $notification = new NotificationData($type, $response, $model);

        CreateSessionFromResponse::handle($notification);
        CreateOrUpdateTokenFromResponse::handle($notification);
        CreateOrUpdateTransactionFromResponse::handle($notification);
        UpdateSubscriptionFromResponse::handle($notification);
    }
}
