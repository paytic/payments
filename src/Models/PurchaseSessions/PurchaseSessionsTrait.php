<?php

namespace Paytic\Payments\Models\PurchaseSessions;

use Exception;
use Nip\Config\Config;
use Omnipay\Common\Message\ResponseInterface;
use Paytic\Payments\Actions\GatewayNotifications\CreateSessionFromResponse;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;
use Paytic\Payments\Models\AbstractModels\HasDatabase\HasDatabaseConnectionTrait;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\PurchaseSessions\Traits\Cleanup\RecordsTrait as CleanupRecordsTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait PurchaseSessionsTrait
 * @package Paytic\Payments\Models\PurchaseSessions
 *
 * @method PurchaseSessionTrait getNew
 */
trait PurchaseSessionsTrait
{
    use CleanupRecordsTrait;
    use HasDatabaseConnectionTrait;

    /**
     * @param string $type
     * @param CompletePurchaseResponseTrait|ResponseInterface $response
     * @return PurchaseSessionTrait
     */
    public function createFromResponse($response, $type)
    {
        return CreateSessionFromResponse::handle($response, $response->getModel(), $type);
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
        if (empty($params)) {
            return $params;
        }
        return unserialize(gzuncompress(base64_decode($params)));
    }

    public static function encodeParams($params)
    {
        return base64_encode(gzcompress(serialize($params)));
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
    public function generateFromPurchaseType($payment, $type)
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
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.' . PaymentsModels::SESSIONS, PurchaseSessions::TABLE);
    }

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateController()
    {
        return PurchaseSessions::CONTROLLER;
    }
}
