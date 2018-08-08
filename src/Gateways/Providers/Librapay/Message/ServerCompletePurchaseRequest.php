<?php

namespace ByTIC\Payments\Gateways\Providers\Librapay\Message;

use ByTIC\Omnipay\Librapay\Message\ServerCompletePurchaseRequest as AbstractServerCompletePurchaseRequest;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Librapay\Helper;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class ServerCompletePurchaseRequest
 * @package ByTIC\Payments\Gateways\Providers\Librapay\Message
 */
class ServerCompletePurchaseRequest extends AbstractServerCompletePurchaseRequest
{
    use HasModelRequest;

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $return = parent::getData();
        // Add model only if has data
        if (count($return)) {
            $return['model'] = $this->getModel();
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getModelIdFromRequest()
    {
        $modelId = $this->getHttpRequestBag()->get('ORDER');
        $modelId = Helper::decodeOrderId($modelId);

        return $modelId;
    }

    /**
     * @inheritdoc
     */
    protected function parseNotification()
    {
        if ($this->validateModel()) {
            $model = $this->getModel();
            $this->updateParametersFromModel($model);
        }

        return parent::parseNotification();
    }

    /**
     * @param IsPurchasableModelTrait $model
     */
    protected function updateParametersFromModel($model)
    {
        $this->setApiKey($model->getPaymentMethod()->getType()->getGateway()->getParameter('apiKey'));
    }
}
