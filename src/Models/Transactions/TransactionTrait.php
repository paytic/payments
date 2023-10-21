<?php

namespace Paytic\Payments\Models\Transactions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
use Paytic\Payments\Models\AbstractModels\HasGateway\HasGatewayRecordTrait;
use Paytic\Payments\Models\AbstractModels\HasMetadata\HasMetadataRecordTrait;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecord;
use Paytic\Payments\Models\AbstractModels\HasPurchaseParent;
use Paytic\Payments\Models\AbstractModels\HasToken\HasTokenRecord;
use Paytic\Payments\Models\Purchases\PurchaseTrait;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Statuses\Active as TransactionActive;
use Paytic\Payments\Transactions\Models\Traits\HasSource\HasSourceRecordTrait;

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
    use HasMetadataRecordTrait;
    use TimestampableTrait;
    use HasSourceRecordTrait, RecordTrait {
        HasSourceRecordTrait::getSmartPropertyValueFromDefinition insteadof RecordTrait;
        RecordTrait::getSmartPropertyValueFromDefinition as getSmartPropertyValueFromDefinitionRecordTrait;
    }

    public ?string $status = null;

    /**
     * @var string
     */
    protected static $createTimestamps = ['created'];

    /**
     * @var string
     */
    protected static $updateTimestamps = ['modified'];

    /**
     * @param Subscription $method
     */
    public function populateFromSubscription($subscription)
    {
        $this->id_subscription = is_object($subscription) ? $subscription->id : $subscription;
    }


    public function isSubscription(): bool
    {
        return $this->id_subscription > 0;
    }

    public function isStatusActive(): bool
    {
        return $this->isInStatus(TransactionActive::NAME);
    }
}
