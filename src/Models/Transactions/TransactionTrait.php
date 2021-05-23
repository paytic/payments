<?php

namespace ByTIC\Payments\Models\Transactions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\DataObjects\Casts\AsArrayObject;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelProcessedResponse;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait as AbstractGateway;
use ByTIC\Payments\Models\AbstractModels\HasPurchaseParent;
use Omnipay\Common\Message\AbstractResponse;

/**
 * Trait TransactionTrait
 * @package ByTIC\Payments\Models\Transactions
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
 * @method TransactionsTrait getManager
 */
trait TransactionTrait
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

    public function bootTransactionTrait()
    {
        $this->addCast('metadata', AsArrayObject::class . ':json');
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->getPropertyValue('metadata');
    }

    public function setMedata($value)
    {
        return $this->setPropertyValue('metadata', $value);
    }

    /**
     * @param $key
     * @param $value
     */
    public function addMedata($key, $value)
    {
        $metadata = $this->metadata;
        $metadata[$key] = $value;
        $this->setMedata($metadata);
    }

    /**
     * @param AbstractResponse|HasModelProcessedResponse $response
     */
    public function updateFromResponse($response, $type)
    {
        $code = $response->getCode();
        if ($code) {
            $this->code = $code;
        }

        $reference = $response->getTransactionReference();
        if ($reference) {
            $this->reference = $reference;
        }

        $this->update();
    }

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
