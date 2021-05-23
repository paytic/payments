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
     * @param $model
     * @param $type
     * @return \ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionTrait
     */
    public static function handle($response, $model, $type): \ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionTrait
    {
        $sessions = PaymentsModels::sessions();

        /** @var IsPurchasableModelTrait $payment */
        $payment = $response->getModel();
        $session = $sessions->generateFromPurchaseType($payment, $type);
        $session->populateFromResponse($response);
        $session->insert();
        return $session;
    }
}