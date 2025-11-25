<?php

namespace Paytic\Payments\Models\Subscriptions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait as HasStatusRecord;
use DateTime;
use Paytic\CommonObjects\Subscription\SubscriptionImplementation;
use Paytic\Payments\Legacy\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecord;
use Paytic\Payments\Models\AbstractModels\HasCustomer\HasCustomerRecord;
use Paytic\Payments\Models\AbstractModels\HasMetadata\HasMetadataRecordTrait;
use Paytic\Payments\Models\AbstractModels\HasToken\HasTokenRecord;
use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\ChargeMethods\AbstractMethod;
use Paytic\Payments\Subscriptions\Statuses\Active;
use Paytic\Payments\Subscriptions\Statuses\Pending;

/**
 * Trait SubscriptionTrait
 * @package Paytic\Payments\Models\Subscriptions
 *
 * @property int $id_method
 * @property int $id_token
 * @property int $id_last_transaction
 * @property int $id_billing_record
 *
 * @property string $billing_period
 * @property int $billing_interval
 * @property int $billing_count
 *
 * @property string|DateTime $start_at
 * @property string|DateTime $cancel_at
 * @property string|DateTime $ended_at
 * @property string|DateTime $charge_at
 *
 * @property int $charge_attempts
 * @property int $charge_count
 * @property int $charge_method
 *
 * @property string $modified
 * @property string $created
 *
 * @method Transaction getLastTransaction
 * @method SubscriptionsTrait getManager
 */
trait SubscriptionTrait
{
    use HasStatusRecord, SubscriptionImplementation {
        SubscriptionImplementation::getStatus insteadof HasStatusRecord;
    }

    use HasPaymentMethodRecord;
    use HasCustomerRecord;
    use HasTokenRecord;
    use HasMetadataRecordTrait;
    use Behaviours\HasTransactions\HasTransactionsRecord;
    use TimestampableTrait;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getManager()->getLabel('title.singular') . ' #' . $this->id;
    }

    /**
     * @var string
     */
    protected static $createTimestamps = ['created'];

    /**
     * @var string
     */
    protected static $updateTimestamps = ['modified'];

    public function bootSubscriptionTrait(): void
    {
        $fields = [
            'start_at' => 'date',
            'cancel_at' => 'date',
            'ended_at' => 'date',
            'charge_at' => 'datetime'
        ];
        foreach ($fields as $field => $cast) {
            if ($this->hasCast($field)) {
                continue;
            }
            $this->addCast($field, $cast);
        }
    }

    /**
     * @return Generic|AbstractMethod
     */
    public function getChargeMethod()
    {
        return $this->getSmartProperty('ChargeMethods');
    }

    /**
     * @param Token $token
     */
    public function populateFromToken($token)
    {
        $this->id_token = $token->id;
        $this->getRelation('Token')->setResults($token);
    }

    public function hasPaymentIssue(): bool
    {
        $status = $this->getStatus();
        if ($status == Pending::NAME) {
            return true;
        }
        if ($this->getStatus() != Active::NAME) {
            return false;
        }
        $lastTransaction = $this->getLastTransaction();
        if ($lastTransaction->getStatus() == \Paytic\Payments\Models\Transactions\Statuses\Active::NAME) {
            return false;
        }
        return true;
    }
}
