<?php

namespace Paytic\Payments\Controllers\Traits\PurchaseController;

use Paytic\Payments\Actions\GatewayNotifications\UpdatePaymentModelsFromResponse;
use Paytic\Payments\Gateways\Manager as GatewaysManager;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Omnipay\Common\Message\AbstractResponse;
use Paytic\Omnipay\Common\Library\View\View;
use Paytic\Omnipay\Common\Message\Traits\HtmlResponses\ConfirmHtmlTrait;

/**
 * Trait PurchaseConfirmActionsTrait
 * @package Paytic\Payments\Controllers\Traits\PurchaseController
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

        UpdatePaymentModelsFromResponse::handle($response, $model, 'confirm');

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
