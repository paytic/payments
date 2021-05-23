<?php

namespace ByTIC\Payments\Models\Tokens;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\Omnipay\Common\Models\TokenInterface;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait as AbstractGateway;
use ByTIC\Payments\Models\AbstractModels\HasPurchaseParent;
use ByTIC\Payments\Models\Methods\PaymentMethod;

/**
 * Trait TokenTrait
 * @package ByTIC\Payments\Models\Tokens
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
 * @method TokensTrait getManager
 */
trait TokenTrait
{
    use HasPurchaseParent;
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
     * @param AbstractGateway $gateway
     */
    public function populateFromGateway($gateway)
    {
        $this->gateway = $gateway->getName();
    }

    /**
     * @param PaymentMethod $gateway
     */
    public function populateFromPaymentMethod($method)
    {
        $this->id_method = is_object($method) ? $method->id : $method;
    }

    /**
     * @param TokenInterface $token
     */
    public function populateFromToken(TokenInterface $token)
    {
        $this->token_id = $token->getId();
        $this->expiration = $token->getExpirationDate();
    }
}
