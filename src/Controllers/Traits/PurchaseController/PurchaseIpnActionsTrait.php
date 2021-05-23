<?php

namespace ByTIC\Payments\Controllers\Traits\PurchaseController;

use ByTIC\Payments\Actions\GatewayNotifications\UpdatePaymentModelsFromResponse;
use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelProcessedResponse;
use ByTIC\Payments\Models\Methods\Traits\RecordTrait as MethodRecordTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
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
        $idGateway = request()->get('paymentMethodId');
        if ($idGateway > 0) {
            $purchaseMethodsManager = $this->getModelManager()->getRelation('Method')->getWith();
            /** @var MethodRecordTrait $purchaseMethod */
            $purchaseMethod = $purchaseMethodsManager->findOne($idGateway);
            $request = $purchaseMethod->getType()->getGateway()->serverCompletePurchase(['modelManager' => $this->getModelManager()]);
            $response = $request->send();
        } else {
            /** @var AbstractResponse|HasModelProcessedResponse $response */
            $response = GatewaysManager::detectItemFromHttpRequest(
                $this->getModelManager(),
                'serverCompletePurchase',
                $this->getRequest()
            );
        }

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

        UpdatePaymentModelsFromResponse::handle($response, $model, 'IPN');

        $this->ipnProcessResponseModel($response, $model);
    }

    /**
     * @param AbstractResponse|HasModelProcessedResponse $response
     * @param IsPurchasableModelTrait $model
     * @return mixed
     */
    abstract protected function ipnProcessResponseModel($response, $model);
}
