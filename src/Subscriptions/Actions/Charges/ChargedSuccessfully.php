<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Paytic\Payments\Subscriptions\Events\Charges\SubscriptionChargeStartAttempt;
use Paytic\Payments\Utility\PaymentsEvents;

/**
 * Class ChargedSuccessfully
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class ChargedSuccessfully extends AbstractChargeWithTransaction
{
    public function execute()
    {
        if ($this->subscription->isTransactionProcessed($this->transaction)) {
            return;
        }
        $this->updateCharge();
    }

    protected function updateCharge()
    {
        $this->subscription->addTransactionProcessed($this->transaction);
        $this->subscription->charge_count = $this->subscription->charge_count + 1;
        $this->subscription->charge_attempts = 0;

        $this->calculateNextCharge();
        $this->subscription->update();

        PaymentsEvents::dispatch(SubscriptionChargeStartAttempt::class, $this->subscription);
    }
}
