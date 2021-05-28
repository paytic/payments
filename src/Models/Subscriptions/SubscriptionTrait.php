<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\Omnipay\Common\Models\SubscriptionInterface;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait as AbstractGateway;
use ByTIC\Payments\Models\AbstractModels\HasGateway\HasGatewayRecordTrait;
use ByTIC\Payments\Models\AbstractModels\HasPurchaseParent;
use ByTIC\Payments\Models\Methods\PaymentMethod;

/**
 * Trait SubscriptionTrait
 * @package ByTIC\Payments\Models\Subscriptions
 *
 * @property int $id_method
 * @property string $gateway
 *
 * @property string $token_id
 * @property string $expiration
 *
 * @property string $modified
 * @property string $created
 *
 * @method SubscriptionsTrait getManager
 */
trait SubscriptionTrait
{
    use HasPurchaseParent;
    use HasGatewayRecordTrait;
    use TimestampableTrait;

    /**
     * @var string
     */
    static protected $createTimestamps = ['created'];

    /**
     * @var string
     */
    static protected $updateTimestamps = ['modified'];

    /**
     * @param PaymentMethod $gateway
     */
    public function populateFromPaymentMethod($method)
    {
        $this->id_method = is_object($method) ? $method->id : $method;
    }

    /**
     * @param SubscriptionInterface $token
     */
    public function populateFromSubscription(SubscriptionInterface $token)
    {
        $this->token_id = $token->getId();
        $this->expiration = $token->getExpirationDate();
    }
}
