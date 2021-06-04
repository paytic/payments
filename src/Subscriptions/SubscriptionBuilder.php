<?php

namespace ByTIC\Payments\Subscriptions;

use ByTIC\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;
use ByTIC\Payments\Models\Methods\PaymentMethod;
use ByTIC\Payments\Models\Methods\Traits\RecordTrait as PaymentMethodTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\Transactions\Transaction;
use ByTIC\Payments\Models\Transactions\TransactionTrait;
use ByTIC\Payments\Subscriptions\ChargeMethods\Internal;
use ByTIC\Payments\Subscriptions\Statuses\NotStarted;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Utility\Date;

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
        $this->subscription->setPropertyValue('status', NotStarted::NAME);
        $this->subscription->charge_method = Internal::NAME;
        $this->subscription->start_at = Date::now();
    }

    /**
     * @param IsPurchasableModelTrait $purchase
     */
    public static function fromPurchase($purchase): SubscriptionBuilder
    {
        $builder = new self();
        $builder->withPaymentMethod($purchase->getPaymentMethod());
        $builder->withCustomer($purchase->getPurchaseBillingRecord());

        $transaction = PaymentsModels::transactions()->findOrCreateForPurchase($purchase);
        $builder->withLastTransaction($transaction);
        return $builder;
    }

    /**
     * @param $status
     * @return SubscriptionBuilder
     */
    public function withStatus($status): SubscriptionBuilder
    {
        $this->subscription->setPropertyValue('status', $status);
        return $this;
    }

    /**
     * @param PaymentMethod|PaymentMethodTrait $method
     */
    public function withPaymentMethod($method): SubscriptionBuilder
    {
        $this->subscription->populateFromPaymentMethod($method);
        return $this;
    }

    /**
     * @param Transaction|TransactionTrait $transaction
     */
    public function withLastTransaction($transaction): SubscriptionBuilder
    {
        $this->subscription->populateFromLastTransaction($transaction);
        return $this;
    }

    /**
     * @param BillingRecord $customer
     */
    public function withCustomer($customer): SubscriptionBuilder
    {
        $this->subscription->populateFromCustomer($customer);
        return $this;
    }

    /**
     * @return \ByTIC\Payments\Models\Subscriptions\Subscription|\ByTIC\Payments\Models\Subscriptions\SubscriptionTrait
     */
    public function create()
    {
        $this->subscription->insert();

        $lastTransaction = $this->subscription->getLastTransaction();
        $lastTransaction->populateFromSubscription($this->subscription);
        $lastTransaction->update();

        return $this->subscription;
    }
}