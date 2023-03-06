<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Bytic\Actions\ObservableAction;
use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class ChargeSubscriptionsDue extends ObservableAction
{
    protected $repository;

    protected $count = 10;

    public function __construct(Subscriptions $repository = null)
    {
        $this->repository = $repository ?? PaymentsModels::subscriptions();
    }

    /**
     * @param $count
     */
    public static function next($count = null)
    {
        $action = new self();
        $action->handle($count);
    }

    public function handle($count = null)
    {
        $this->count = $count ?? $this->count;
        $this->execute($this->count);
    }

    /**
     * @param $count
     * @return bool
     */
    protected function execute($count)
    {
        $this->info('START ' . self::class);
        $this->repository->findChargeDue($count)
            ->each(function ($subscription) {
                $this->info('TRY CHARGE FOR ID:' . $subscription->id);
                $action = new ChargeSubscription($subscription);
                $action->attachAll($this->getObservers());
                $action->execute();
            });
        $this->info('END ' . self::class);
        return true;
    }
}
