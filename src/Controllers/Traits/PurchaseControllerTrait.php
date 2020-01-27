<?php

namespace ByTIC\Payments\Controllers\Traits;

use ByTIC\Common\Records\Record;
use ByTIC\FacebookPixel\FacebookPixel;
use ByTIC\Omnipay\Common\Message\Traits\RedirectHtmlTrait;
use ByTIC\Payments\Controllers\Traits\PurchaseController\PurchaseConfirmActionsTrait;
use ByTIC\Payments\Controllers\Traits\PurchaseController\PurchaseIpnActionsTrait;
use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Records\RecordManager;
use Nip\Request;

/**
 * Class PurchaseControllerTrait
 * @package ByTIC\Common\Payments\Controllers\Traits
 *
 * @method IsPurchasableModelTrait checkItem
 */
trait PurchaseControllerTrait
{
    use PurchaseConfirmActionsTrait;
    use PurchaseIpnActionsTrait;

    public function redirectToPayment()
    {
        $model = $this->getModelFromRequest();
        $request = $model->getPurchaseRequest();
        /** @var RedirectHtmlTrait $response */
        $response = $request->send();
        $this->redirectToPaymentPrepareResponse($response, $model);
        $response->getRedirectResponse()->send();
        die();
    }

    /**
     * @param RedirectHtmlTrait $response
     * @param Record|IsPurchasableModelTrait $model
     */
    protected function redirectToPaymentPrepareResponse($response, $model)
    {
        $response->getView()->set('subtitle', $model->getPurchaseName());
        $response->getView()->set('item', $model);
        $response->getView()->set('response', $model);

        if (method_exists($this, 'getFacebookPixelToPaymentResponse')) {
            /** @var FacebookPixel $facebookPixel */
            $facebookPixel = $this->getFacebookPixelToPaymentResponse($model);
            $response->getView()->append('footer_body', $facebookPixel->render());
        }
    }

    /**
     * @param bool|array $key
     * @return Record|IsPurchasableModelTrait
     */
    abstract protected function getModelFromRequest($key = false);

    /**
     * @return GatewaysManager
     */
    protected function getGatewaysManager()
    {
        return GatewaysManager::instance();
    }

    /**
     * @param AbstractResponse $response
     * @return void
     */
    abstract protected function ipnProcessResponse($response);

    /**
     * @return RecordManager
     */
    abstract protected function getModelManager();

    /**
     * @return Request
     */
    abstract protected function getRequest();

    abstract protected function dispatchAccessDeniedResponse();

    /**
     * @param CompletePurchaseResponseTrait $response
     * @return void
     */
    abstract protected function confirmProcessResponse($response);
}
