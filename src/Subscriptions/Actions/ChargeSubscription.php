<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Bytic\Actions\ObservableAction;
use Exception;
use Nip\Records\Record;
use Paytic\CommonObjects\Subscription\Exception\SubscriptionNotChargeable;
use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedFailed;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedSuccessfully;
use Paytic\Payments\Subscriptions\Events\Charges\SubscriptionChargeStartAttempt;
use Paytic\Payments\Transactions\Actions\ChargeWithToken;
use Paytic\Payments\Transactions\Actions\CreateNewTransactionInSubscription;
use Paytic\Payments\Utility\PaymentsEvents;

/**
 * Class ChargeSubscription
 * @package Paytic\Payments\Subscriptions\Actions
 */
class ChargeSubscription extends ObservableAction
{
    protected SubscriptionInterface $subscription;

    /**
     * @param SubscriptionInterface $subscription
     */
    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public static function handle($subscription)
    {
        (new self($subscription))->execute();
    }

    public function execute()
    {
        $this->info('START ' . self::class);
        $this->info('--ID:' . $this->subscription->id);

        PaymentsEvents::dispatch(SubscriptionChargeStartAttempt::class, $this->subscription);

        try {
            $this->subscription->guardIsChargeable();
        } catch (SubscriptionNotChargeable $exception) {
            $this->error('----- SUBSCRIPTION NOT CHARGEABLE: ' . $exception->getMessage());
            return;
        }

        $transaction = $this->determineTransaction();
        $this->chargeTransaction($transaction);
        $this->info('END ' . self::class);
    }

    protected function determineTransaction(): Transaction|Record
    {
        if ($this->subscription->charge_attempts > 0) {
            return $this->subscription->getLastTransaction();
        }

        return CreateNewTransactionInSubscription::for($this->subscription);
    }

    /**
     * @param Transaction $transaction
     * @return void
     */
    protected function chargeTransaction($transaction): void
    {
        if ($this->tryChargeTransaction($transaction) === false) {
            $this->executeOnFailed($transaction);
            return;
        }

        $this->executeOnSuccess($transaction);
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    protected function tryChargeTransaction($transaction): bool
    {
        try {
            ChargeWithToken::process($transaction);
        } catch (Exception $exception) {
            return false;
        }

        if (false === $transaction->isStatusActive()) {
            return false;
        }

        return true;
    }

    /**
     * @param $transaction
     * @return void
     */
    protected function executeOnSuccess($transaction): void
    {
        ChargedSuccessfully::handle($this->subscription, $transaction);
    }

    /**
     * @param $transaction
     * @return void
     */
    protected function executeOnFailed($transaction): void
    {
        ChargedFailed::handle($this->subscription, $transaction);
    }
}
