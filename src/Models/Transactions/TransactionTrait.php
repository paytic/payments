<?php

namespace ByTIC\Payments\Models\Transactions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\DataObjects\Casts\Metadata\AsMetadataObject;
use ByTIC\Payments\Models\AbstractModels\HasGateway\HasGatewayRecordTrait;
use ByTIC\Payments\Models\AbstractModels\HasPurchaseParent;
use ByTIC\Payments\Models\Subscriptions\Subscription;

/**
 * Trait TransactionTrait
 * @package ByTIC\Payments\Models\Transactions
 *
 * @property int $id_purchase
 * @property int $id_subscription
 * @property int $id_token
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
 * @method Subscription getSubscription
 */
trait TransactionTrait
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

    public function bootTransactionTrait()
    {
        $this->addCast('metadata', AsMetadataObject::class . ':json');
    }

    /**
     * @param Subscription $method
     */
    public function populateFromSubscription($subscription)
    {
        $this->id_subscription = is_object($subscription) ? $subscription->id : $subscription;
    }
    /**
     * @param $key
     * @param $value
     */
    public function addMedata($key, $value)
    {
        $this->metadata->set($key, $value);
    }

    public function isSubscription(): bool
    {
        return $this->id_subscription > 0;
    }
}
