<?php

namespace Paytic\Payments\Subscriptions\Actions;

use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class ChargeSubscriptionsDue
{
    protected $repository;

    public function __construct(Subscriptions $repository = null)
    {

        $this->repository = $repository ?? PaymentsModels::subscriptions();
    }

    /**
     * @param $count
     * @return null
     */
    public static function next($count = 10)
    {
        $action = new self();
        return $action->execute($count);
    }

    /**
     * @param $count
     * @return bool
     */
    protected function execute($count)
    {
        $this->repository->findChargeDue($count)
            ->each(function ($subscription) {
                ChargeSubscription::handle($subscription);
            });
        return true;
    }
}