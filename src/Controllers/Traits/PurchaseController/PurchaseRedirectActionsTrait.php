<?php

namespace ByTIC\Payments\Controllers\Traits\PurchaseController;

use ByTIC\Common\Records\Record;
use ByTIC\FacebookPixel\FacebookPixel;
use ByTIC\Omnipay\Common\Message\Traits\RedirectHtmlTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait PurchaseRedirectActionsTrait
 * @package ByTIC\Payments\Controllers\Traits\PurchaseController
 */
trait PurchaseRedirectActionsTrait
{
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
}