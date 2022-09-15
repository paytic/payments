<?php

namespace Paytic\Payments\Actions\Subscriptions;

use Exception;
use Paytic\Payments\Actions\Subscriptions\Charges\ChargedFailed;
use Paytic\Payments\Actions\Transactions\ChargeWithToken;
use Paytic\Payments\Actions\Transactions\CreateNewForSubscription;
use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class ChargeSubscription
 * @package Paytic\Payments\Actions\Subscriptions
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
        } catch (Exception $exception) {
            ChargedFailed::handle($subscription);
        }
    }
}
