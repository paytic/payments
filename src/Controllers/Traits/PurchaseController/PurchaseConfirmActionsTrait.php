<?php

namespace ByTIC\Payments\Controllers\Traits\PurchaseController;

use ByTIC\Omnipay\Common\Message\Traits\HtmlResponses\ConfirmHtmlTrait;
use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionsTrait;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionTrait;
use Nip\Records\Locator\ModelLocator;
use Omnipay\Common\Message\AbstractResponse;

/**
 * Trait PurchaseConfirmActionsTrait
 * @package ByTIC\Payments\Controllers\Traits\PurchaseController
 */
trait PurchaseConfirmActionsTrait
{

    public function confirm()
    {
        $response = $this->getConfirmActionResponse();
        $model = $response->getModel();
        if ($model) {
            $response->processModel();
        }
        $this->confirmProcessResponse($response);
        $response->send();
        die();
    }

    /**
     * @return CompletePurchaseResponseTrait|ConfirmHtmlTrait
     */
    protected function getConfirmActionResponse()
    {
        /** @var CompletePurchaseResponseTrait $response */
        $response = GatewaysManager::detectItemFromHttpRequest(
            $this->getModelManager(),
            'completePurchase',
            $this->getRequest()
        );

        if (($response instanceof AbstractResponse) === false) {
            $this->dispatchAccessDeniedResponse();
        }

        return $response;
    }

    /**
     * @param CompletePurchaseResponseTrait|ConfirmHtmlTrait $response
     */
    protected function confirmProcessResponse($response)
    {
        /** @var IsPurchasableModelTrait $model */
        $model = $response->getModel();

        /** @var PurchaseSessionsTrait $sessions */
        $sessions = ModelLocator::get('PurchaseSessions');
        $sessions->createFromResponse($response, 'confirm');

        $this->confirmProcessResponseTitle($response, $model);
        $this->confirmProcessResponseMessage($response, $model);
        $this->confirmProcessResponseButton($response, $model);
        $this->confirmProcessResponseModel($response, $model);

        if ($model) {
//            $this->_detectEvent($model);
//            /** @var Order $order */
//            $order = $model->getOrder();


            $buttonUrl = $order ? $order->getURL() : $model->getURL();
            $response->setButton('Click aici pentru a continua.', $buttonUrl);
            Payment_Sessions::instance()->createFromPurchase($model, 'confirm');

            if ($model->getStatus()->getName() == 'active') {
                $model->autoConfirmOnlineEntries();
                $redirectUrl = $this->getRedirectOrderUrl($model);
                $response->setRedirectUrl($redirectUrl);
            }
        }
    }

    /**
     * @param CompletePurchaseResponseTrait|ConfirmHtmlTrait $response
     */
    protected function confirmProcessResponseTitle($response, $model)
    {
        if ($model) {
            $response->getView()->set('title', 'Error confirming payment');
            return;
        }
        $response->getView()->set(
            'title',
            translator()->trans('payment-gateways.messages.confirm.' . $response->getMessageType() . '.title')
        );
    }

    protected function confirmProcessResponseMessage($response, $model)
    {
        if (!$model) {
            return;
        }
        $response->getView()->set(
            'message',
            $model->getManager()->getMessage('confirm.' . $model->status)
        );
    }

    protected function confirmProcessResponseButton($response, $model)
    {
        if (!$model) {
            return;
        }

        $buttonUrl = $model->getURL();
        $response->setButton('Click aici pentru a continua.', $buttonUrl);
    }

    protected abstract function confirmProcessResponseModel($response, $model);
}