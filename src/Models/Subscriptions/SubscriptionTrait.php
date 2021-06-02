<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\DataObjects\Casts\Metadata\AsMetadataObject;
use ByTIC\Omnipay\Common\Models\SubscriptionInterface;
use ByTIC\Payments\Models\AbstractModels\HasCustomer\HasCustomerRecord;
use ByTIC\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecordTrait;
use ByTIC\Payments\Models\Tokens\Token;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\TransactionTrait;
use DateTime;

/**
 * Trait SubscriptionTrait
 * @package ByTIC\Payments\Models\Subscriptions
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
 * @method SubscriptionsTrait getManager
 */
trait SubscriptionTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
    use HasPaymentMethodRecordTrait;
    use HasCustomerRecord;
    use TimestampableTrait;

    /**
     * @var string
     */
    static protected $createTimestamps = ['created'];

    /**
     * @var string
     */
    static protected $updateTimestamps = ['modified'];

    public function bootSubscriptionTrait()
    {
        $fields = ['start_at', 'cancel_at', 'ended_at', 'charge_at'];
        foreach ($fields as $field) {
            if ($this->hasCast($field)) {
                continue;
            }
            $this->addCast($field, 'datetime');
        }
        $this->addCast('metadata', AsMetadataObject::class . ':json');
    }

    /**
     * @param $key
     * @param $value
     */
    public function addMedata($key, $value)
    {
        $this->metadata->set($key, $value);
    }

    /**
     * @param Transaction|TransactionTrait $transaction
     */
    public function populateFromLastTransaction($transaction)
    {
        $this->id_last_transaction = $transaction->id;
        $this->getRelation('LastTransaction')->setResults($transaction);
    }

    /**
     * @param Token $token
     */
    public function populateFromToken($token)
    {
        $this->id_token = $token->id;
        $this->getRelation('Token')->setResults($token);
    }
}
