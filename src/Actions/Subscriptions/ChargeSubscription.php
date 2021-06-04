<?php

namespace ByTIC\Payments\Actions\Subscriptions;

use ByTIC\Payments\Actions\Purchases\DuplicatePurchase;
use ByTIC\Payments\Actions\Subscriptions\Charges\CalculateNextCharge;
use ByTIC\Payments\Actions\Subscriptions\Charges\ChargedFailed;
use ByTIC\Payments\Actions\Transactions\ChargeWithToken;
use ByTIC\Payments\Actions\Transactions\CreateNewForSubscription;
use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Models\Tokens\Token;
use ByTIC\Payments\Subscriptions\Statuses\Active;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Class ChargeSubscription
 * @package ByTIC\Payments\Actions\Subscriptions
 */
class ChargeSubscription
{
    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        $transaction = CreateNewForSubscription::handle($subscription);

        try {
            ChargeWithToken::process($transaction);
        } catch (\Exception $exception) {
            ChargedFailed::handle($subscription);
        }
    }
}