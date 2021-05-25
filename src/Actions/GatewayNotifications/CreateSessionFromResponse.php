<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Class CreateSessionFromResponse
 * @package ByTIC\Payments\Actions\GatewayNotifications
 */
class CreateSessionFromResponse
{
    /**
     * @param $response
     * @param IsPurchasableModelTrait $model
     * @param $type
     * @return \ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionTrait
     */
    public static function handle($response, $model, $type)
    {
        $sessions = PaymentsModels::sessions();

        $session = $sessions->generateFromPurchaseType($model, $type);
        $session->populateFromResponse($response);
        $session->insert();
        return $session;
    }
}