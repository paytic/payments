<?php

namespace ByTIC\Payments\Gateways\Providers\Librapay\Message\Traits;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasGatewayRequestTrait;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
use ByTIC\Payments\Gateways\Providers\Librapay\Gateway;
use ByTIC\Payments\Gateways\Providers\Librapay\Helper;

/**
 * Trait CompletePurchaseTrait
 */
trait CompletePurchaseTrait
{
    use HasModelRequest;
    use HasGatewayRequestTrait;

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
            $this->updateParametersFromPurchase($model);
        }

        return parent::parseNotification();
    }

    /**
     * @param Gateway $gateway
     */
    protected function updateParametersFromGateway($gateway)
    {
        $this->setMerchant($gateway->getMerchant());
        $this->setTerminal($gateway->getTerminal());
        $this->setKey($gateway->getKey());
        $this->setMerchantName($gateway->getMerchantName());
        $this->setMerchantEmail($gateway->getMerchantEmail());
        $this->setMerchantUrl($gateway->getMerchantUrl());
    }
}
