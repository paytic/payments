<?php

namespace Paytic\Payments\Subscriptions\Listeners;

use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Purchases\Events\PurchaseConfirmed;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedSuccessfully;

/**
 *
 */
class SubscriptionPurchaseListener
{
    public static function handleConfirmed(PurchaseConfirmed $event): void
    {
        /** @var IsPurchasableModelTrait $purchase */
        $purchase = $event->getSubject();
        $transaction = $purchase->getPaymentTransaction();
        if (!is_object($transaction)) {
            return;
        }
        $subscription = $purchase->getSubscription();
        if (!is_object($subscription)) {
            return;
        }

        if (!$transaction->isInStatus(Active::NAME)) {
            return;
        }

        ChargedSuccessfully::handle($subscription, $transaction);
    }
}
