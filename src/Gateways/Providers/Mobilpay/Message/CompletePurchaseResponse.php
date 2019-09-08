<?php

namespace ByTIC\Payments\Gateways\Providers\Mobilpay\Message;

use ByTIC\Omnipay\Mobilpay\Message\CompletePurchaseResponse as AbstractCompletePurchaseResponse;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\CompletePurchaseResponseTrait;

/**
 * Class CompletePurchaseResponse
 * @package ByTIC\Payments\Gateways\Providers\Mobilpay\Message
 */
class CompletePurchaseResponse extends AbstractCompletePurchaseResponse
{
    use CompletePurchaseResponseTrait;

    /**
     * @inheritDoc
     */
    public function isPending()
    {
        $model = $this->getModel();
        if ($model) {
            if (empty($model->status) or $model->status === 'pending') {
                return true;
            }
        }
        return parent::isPending();
    }

    /**
     * @inheritDoc
     */
    public function isCancelled()
    {
        $model = $this->getModel();
        if ($model) {
            if ($model->status === 'canceled') {
                return true;
            }
        }
        return parent::isCancelled();
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        $model = $this->getModel();
        if ($model) {
            if ($model->status === 'active') {
                return true;
            }
        }
        return parent::isSuccessful();
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return bool
     */
    protected function canProcessModel()
    {
        return false;
    }
}
