<?php

namespace ByTIC\Payments\Models\PurchaseSessions;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\PurchaseSessions\Traits\Cleanup\RecordsTrait as CleanupRecordsTrait;

/**
 * Trait PurchaseSessionsTrait
 * @package ByTIC\Payments\Models\PurchaseSessions
 *
 * @method PurchaseSessionTrait getNew
 */
trait PurchaseSessionsTrait
{
    use CleanupRecordsTrait;

    /**
     * @param string $type
     * @param CompletePurchaseResponseTrait $response
     * @return PurchaseSessionTrait
     */
    public function createFromResponse($response, $type)
    {
        $payment = $response->getModel();
        $session = $this->generateFromPurchaseType($payment, $type);
        $session->populateFromResponse($response);
        $session->insert();

        return $session;
    }

    /**
     * @param string $type
     * @param IsPurchasableModelTrait $payment
     * @return PurchaseSessionTrait
     */
    public function createFromPurchase($payment, $type)
    {
        $session = $this->generateFromPurchaseType($payment, $type);
        $session->insert();

        return $session;
    }

    protected function generateFromPurchaseType($payment, $type)
    {
        $session = $this->generateFromPurchase($payment);
        $session->type = $type;
        return $session;
    }

    /**
     * @param IsPurchasableModelTrait $payment
     * @return PurchaseSessionTrait
     */
    protected function generateFromPurchase($payment)
    {
        $session = $this->getNew();
        $session->populateFromPayment($payment);
        $session->populateFromGateway($payment->getPaymentMethod()->getType()->getGateway());
        $session->populateFromRequest();

        return $session;
    }
}
