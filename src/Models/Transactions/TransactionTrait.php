<?php

namespace Paytic\Payments\Models\Transactions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\DataObjects\Casts\Metadata\AsMetadataObject;
use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
use Paytic\Payments\Models\AbstractModels\HasGateway\HasGatewayRecordTrait;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecord;
use Paytic\Payments\Models\AbstractModels\HasPurchaseParent;
use Paytic\Payments\Models\AbstractModels\HasToken\HasTokenRecord;
use Paytic\Payments\Models\Purchases\PurchaseTrait;
use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Trait TransactionTrait
 * @package Paytic\Payments\Models\Transactions
 *
 * @property int $id_purchase
 * @property int $id_subscription
 * @property int $id_token
 * @property string $gateway
 * @property int $amount
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
 * @method PurchaseTrait getPurchase
 * @method Subscription getSubscription
 */
trait TransactionTrait
{
    use HasPurchaseParent;
    use HasTokenRecord;
    use HasPaymentMethodRecord;
    use HasGatewayRecordTrait;
    use TimestampableTrait;
    use RecordTrait;

    public ?string $status = null;

    /**
     * @var string
     */
    protected static $createTimestamps = ['created'];

    /**
     * @var string
     */
    protected static $updateTimestamps = ['modified'];

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
