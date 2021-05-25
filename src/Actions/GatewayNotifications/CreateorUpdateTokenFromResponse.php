<?php

namespace ByTIC\Payments\Actions\GatewayNotifications;

use ByTIC\Omnipay\Common\Models\TokenInterface;
use ByTIC\Payments\Models\Purchases\Purchase;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Class CreateorUpdateTokenFromResponse
 * @package ByTIC\Payments\Actions\GatewayNotifications
 */
class CreateorUpdateTokenFromResponse
{
    /**
     * @param $response
     * @param Purchase $model
     * @param $type
     * @return \ByTIC\Payments\Models\Transactions\TransactionTrait|\Nip\Records\AbstractModels\Record
     */
    public static function handle($response, $model, $type)
    {
        if (!method_exists($response, 'getToken')) {
            return null;
        }
        $token = $response->getToken();
        if (!($token instanceof TokenInterface)) {
            return null;
        }
        if (empty($token->getId())) {
            return null;
        }
        return PaymentsModels::tokens()->findOrCreateForMethod($model->getPaymentMethod(), $token);
    }
}