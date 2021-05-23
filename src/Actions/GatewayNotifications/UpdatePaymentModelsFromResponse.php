<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

/**
 * Class UpdatePaymentModelsFromResponse
 * @package ByTIC\Payments\Actions
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
        CreateSessionFromResponse::handle($response, $model, $type);
        CreateOrUpdateTransactionFromResponse::handle($response, $model, $type);
        CreateorUpdateTokenFromResponse::handle($response, $model, $type);
    }

}
