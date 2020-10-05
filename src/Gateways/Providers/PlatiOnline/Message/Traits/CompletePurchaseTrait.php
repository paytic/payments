<?php

namespace ByTIC\Payments\Gateways\Providers\PlatiOnline\Message\Traits;

use ByTIC\Payments\Gateways\Providers\Librapay\Gateway;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Trait CompletePurchaseTrait
 * @package ByTIC\Payments\Gateways\Providers\PlatiOnline\Message\Traits
 */
trait CompletePurchaseTrait
{

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
     * @return bool|mixed
     * @throws \Exception
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
     *
     * @throws \Exception
     */
    protected function updateParametersFromModel($model)
    {
        /** @var \ByTIC\Payments\Gateways\Providers\PlatiOnline\Gateway $modelGateway */
        $modelGateway = $model->getPaymentMethod()->getType()->getGateway();
        $this->setPrivateKey($modelGateway->getPrivateKey());
        $this->setInitialVectorItsn($modelGateway->getInitialVectorItsn());
    }
}
