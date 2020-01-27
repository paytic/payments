<?php

namespace ByTIC\Payments\Controllers\Traits\PurchaseController;

use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelProcessedResponse;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionsTrait;
use Nip\Records\Locator\ModelLocator;
use Omnipay\Common\Message\AbstractResponse;

/**
 * Trait PurchaseIpnActionsTrait
 * @package ByTIC\Payments\Controllers\Traits\PurchaseController
 */
trait PurchaseIpnActionsTrait
{
    public function ipn()
    {
        $response = $this->getIpnActionResponse();
        $model = $response->getModel();
        if ($model) {
            $response->processModel();
        }
        $this->ipnProcessResponse($response);
        $response->send();
        die();
    }

    /**
     * @return AbstractResponse|HasModelProcessedResponse
     */
    protected function getIpnActionResponse()
    {
        /** @var AbstractResponse|HasModelProcessedResponse $response */
        $response = GatewaysManager::detectItemFromHttpRequest(
            $this->getModelManager(),
            'serverCompletePurchase',
            $this->getRequest()
        );

        if (($response instanceof AbstractResponse) === false) {
            $this->dispatchAccessDeniedResponse();
        }

        return $response;
    }

    /**
     * @param AbstractResponse|HasModelProcessedResponse $response
     */
    protected function ipnProcessResponse($response)
    {
        /** @var IsPurchasableModelTrait $model */
        $model = $response->getModel();

        /** @var PurchaseSessionsTrait $sessions */
        $sessions = ModelLocator::get('PurchaseSessions');
        $sessions->createFromResponse($response, 'IPN');

        $this->ipnProcessResponseModel($response, $model);
    }

    protected abstract function ipnProcessResponseModel($response, $model);
}
