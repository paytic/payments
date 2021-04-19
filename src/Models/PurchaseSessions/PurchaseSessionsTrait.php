<?php

namespace ByTIC\Payments\Models\PurchaseSessions;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\PurchaseSessions\Traits\Cleanup\RecordsTrait as CleanupRecordsTrait;
use ByTIC\Payments\Utility\PaymentsModels;
use Omnipay\Common\Message\ResponseInterface;

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
     * @param CompletePurchaseResponseTrait|ResponseInterface $response
     * @return PurchaseSessionTrait
     */
    public function createFromResponse($response, $type)
    {
        /** @var IsPurchasableModelTrait $payment */
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

    /**
     * @param $params
     * @return mixed
     */
    public static function decodeParams($params)
    {
        return unserialize(gzuncompress(base64_decode($params)));
    }

    protected function initRelations()
    {
        parent::initRelations();
    }

    protected function initRelationsCommon()
    {
        $this->initRelationsPurchase();
    }

    protected function initRelationsPurchase()
    {
        $this->belongsTo('Purchase', ['class' => get_class(PaymentsModels::purchases())]);
    }

    /**
     * @param array $params
     */
    protected function injectParams(&$params = [])
    {
        $params['order'][] = ['created', 'desc'];

        parent::injectParams($params);
    }

    /**
     * @param IsPurchasableModelTrait $payment
     * @param string $type
     * @return PurchaseSessionTrait
     */
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

    /**
     * @return mixed|\Nip\Config\Config
     * @throws \Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.purchases_sessions', 'purchases_sessions');
    }
}
