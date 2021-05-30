<?php

namespace ByTIC\Payments\Subscriptions;

use ByTIC\Payments\Models\Methods\PaymentMethod;
use ByTIC\Payments\Models\Methods\Traits\RecordTrait as PaymentMethodTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\TransactionTrait;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Class SubscriptionBuilder
 * @package ByTIC\Payments\Utility
 */
class SubscriptionBuilder
{
    use Builder\ManageBillingCycle;

    /**
     * @var \ByTIC\Payments\Models\Subscriptions\Subscription
     */
    protected $subscription;

    /**
     * SubscriptionBuilder constructor.
     */
    protected function __construct()
    {
        $this->subscription = PaymentsModels::subscriptions()->getNew();
    }

    /**
     * @param IsPurchasableModelTrait $purchase
     */
    public static function fromPurchase($purchase): SubscriptionBuilder
    {
        $builder = new static();
        $builder->withPaymentMethod($purchase->getPaymentMethod());
        $builder->withLastTransaction(PaymentsModels::transactions()->findOrCreateForPurchase($purchase));
        return $builder;
    }

    /**
     * @param PaymentMethod|PaymentMethodTrait $method
     */
    public function withPaymentMethod($method)
    {
        $this->subscription->populateFromPaymentMethod($method);
        $this->subscription->populateFromGateway($method->getGateway());
    }

    /**
     * @param Transaction|TransactionTrait $transaction
     */
    public function withLastTransaction($transaction)
    {
        $this->subscription->id_last_transaction = $transaction->id;
    }

    /**
     * @return \ByTIC\Payments\Models\Subscriptions\Subscription|\ByTIC\Payments\Models\Subscriptions\SubscriptionTrait
     */
    public function create()
    {
        $this->subscription->insert();
        return $this->subscription;
    }
}