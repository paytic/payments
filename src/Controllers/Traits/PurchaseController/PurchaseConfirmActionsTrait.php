<?php

namespace ByTIC\Payments\Controllers\Traits\PurchaseController;

use ByTIC\Omnipay\Common\Library\View\View;
use ByTIC\Omnipay\Common\Message\Traits\HtmlResponses\ConfirmHtmlTrait;
use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionsTrait;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\Locator\ModelLocator;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Trait PurchaseConfirmActionsTrait
 * @package ByTIC\Payments\Controllers\Traits\PurchaseController
 *
 * @method getModelManager()
 * @method dispatchAccessDeniedResponse()
 */
trait PurchaseConfirmActionsTrait
{
    public function confirm()
    {
        $response = $this->getConfirmActionResponse();
        $model = $response->getModel();
        if (is_object($model)) {
            $response->processModel();
        }
        $this->confirmProcessResponse($response);
        $response->send();
        die();
    }

    /**
     * @return AbstractResponse|CompletePurchaseResponseTrait|ConfirmHtmlTrait
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
     * @param AbstractResponse|CompletePurchaseResponseTrait|ConfirmHtmlTrait $response
     */
    protected function confirmProcessResponse($response)
    {
        /** @var IsPurchasableModelTrait $model */
        $model = $response->getModel();

        PaymentsModels::sessions()
            ->createFromResponse($response, 'confirm');

        PaymentsModels::transactions()
            ->findOrCreateForPurchase($model)
            ->updateFromResponse($response, 'confirm');

        $this->confirmProcessResponseTitle($response, $model);
        $this->confirmProcessResponseMessage($response, $model);
        $this->confirmProcessResponseButton($response, $model);
        $this->confirmProcessResponseModel($response, $model);
    }

    /**
     * @param AbstractResponse|CompletePurchaseResponseTrait|ConfirmHtmlTrait $response
     * @param IsPurchasableModelTrait $model
     */
    protected function confirmProcessResponseTitle($response, $model)
    {
        if (!is_object($model)) {
            $response->getView()->set('title', 'Error confirming payment');
            return;
        }
        $response->getView()->set(
            'title',
            translator()->trans('payment-gateways.messages.confirm.' . $response->getMessageType() . '.title')
        );
    }

    /**
     * @param AbstractResponse|CompletePurchaseResponseTrait|ConfirmHtmlTrait $response
     * @param IsPurchasableModelTrait $model
     */
    protected function confirmProcessResponseMessage($response, $model)
    {
        if (!is_object($model)) {
            return;
        }
        $response->getView()->set(
            'message',
            $model->getManager()->getMessage('confirm.' . $model->status)
        );
    }

    /**
     * @param AbstractResponse|CompletePurchaseResponseTrait|ConfirmHtmlTrait $response
     * @param IsPurchasableModelTrait $model
     */
    protected function confirmProcessResponseButton($response, $model)
    {
        if (!is_object($model)) {
            return;
        }

        $buttonUrl = $model->getURL();
        $response->setButton('Click aici pentru a continua.', $buttonUrl);
    }

    /**
     * @param AbstractResponse|CompletePurchaseResponseTrait|ConfirmHtmlTrait $response
     * @param IsPurchasableModelTrait $model
     */
    abstract protected function confirmProcessResponseModel($response, $model);

    /**
     * @return View|null
     */
    abstract public function getView();
}
