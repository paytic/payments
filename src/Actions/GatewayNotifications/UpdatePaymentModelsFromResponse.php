<?php

namespace Paytic\Payments\Actions\GatewayNotifications;

use Paytic\Payments\Tokens\Actions\GatewayNotifications\CreateOrUpdateTokenFromResponse;

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
        CreateOrUpdateTransactionFromResponse::handle($notification);
        CreateOrUpdateTokenFromResponse::handle($notification);
        UpdateSubscriptionFromResponse::handle($notification);
    }
}
