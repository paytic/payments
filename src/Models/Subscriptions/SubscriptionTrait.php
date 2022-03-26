<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\DataObjects\Casts\Metadata\AsMetadataObject;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
use ByTIC\Payments\Models\AbstractModels\HasCustomer\HasCustomerRecord;
use ByTIC\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecord;
use ByTIC\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecordTrait;
use ByTIC\Payments\Models\AbstractModels\HasToken\HasTokenRecord;
use ByTIC\Payments\Models\Tokens\Token;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\TransactionTrait;
use ByTIC\Payments\Subscriptions\ChargeMethods\AbstractMethod;
use DateTime;
use Paytic\Omnipay\Common\Models\SubscriptionInterface;

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
 * @method Transaction getLastTransaction
 * @method SubscriptionsTrait getManager
 */
trait SubscriptionTrait
{
    use RecordTrait;
    use HasPaymentMethodRecord;
    use HasCustomerRecord;
    use HasTokenRecord;
    use TimestampableTrait;

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

    public function bootSubscriptionTrait()
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
     * @return Generic|AbstractMethod
     */
    public function getChargeMethod()
    {
        return $this->getSmartProperty('ChargeMethods');
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
