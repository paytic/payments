<?php

namespace Paytic\Payments\Models\Subscriptions;

/**
 *
 */
interface SubscriptionInterface extends \Paytic\CommonObjects\Subscription\SubscriptionInterface
{
    public const META_TRANSACTIONS_PROCESSED = 'transactions.processed';
}