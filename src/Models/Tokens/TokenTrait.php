<?php

namespace ByTIC\Payments\Models\Tokens;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait as AbstractGateway;
use ByTIC\Payments\Models\AbstractModels\HasPurchaseParent;

/**
 * Trait TokenTrait
 * @package ByTIC\Payments\Models\Tokens
 *
 * @property int $id_purchase
 * @property string $gateway
 * @property string $currency
 *
 * @property string $card
 * @property string $code A response code from the payment gateway
 * @property string $reference A reference provided by the gateway to represent this transaction
 * @property string $metadata
 *
 * @property string $modified
 * @property string $created
 *
 * @method TokensTrait getManager
 */
trait TokenTrait
{
    use HasPurchaseParent;

    /**
     * @param AbstractGateway $gateway
     */
    public function populateFromGateway($gateway)
    {
        $this->gateway = $gateway->getName();
    }

    /**
     * @inheritdoc
     */
    public function insert()
    {
        $this->created = date('Y-m-d H:i:s');

        return parent::insert();
    }

}
