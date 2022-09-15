<?php

namespace Paytic\Payments\Controllers\Traits\PurchaseController;

use ByTIC\FacebookPixel\FacebookPixel;
use Paytic\Omnipay\Common\Message\Traits\RedirectHtmlTrait;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Trait PurchaseRedirectActionsTrait
 * @package Paytic\Payments\Controllers\Traits\PurchaseController
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

        if ($response instanceof RedirectResponseInterface  && $response->isRedirect()) {
            $response->getRedirectResponse()->send();
        } else {
            $response->send();
        }
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
