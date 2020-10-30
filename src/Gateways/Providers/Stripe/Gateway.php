<?php

namespace ByTIC\Payments\Gateways\Providers\Stripe;

use Omnipay\Stripe\PaymentIntentsGateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\OverwriteServerCompletePurchaseTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Stripe
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;
    use OverwriteServerCompletePurchaseTrait;

    /**
     * @inheritDoc
     */
    public function setSandbox($value): self
    {
        return $this->setTestMode($value == 'yes');
    }

    /**
     * @inheritDoc
     */
    public function getSandbox(): string
    {
        return $this->getTestMode() === true ? 'yes' : 'no';
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        if (strlen($this->getApiKey()) >= 5) {
            return true;
        }

        return false;
    }
}
