<?php

namespace Paytic\Payments\Subscriptions\Builder;

use Paytic\Payments\Subscriptions\Billing\BillingPeriod;
use Exception;

/**
 * Trait ManageBillingCycle
 * @package Paytic\Payments\Subscriptions\Builder
 */
trait ManageBillingCycle
{

    /**
     * @param int $every
     * @return self
     */
    public function daily($every = 1)
    {
        return $this->billEvery($every, BillingPeriod::DAILY);
    }

    /**
     * @param int $every
     * @return self
     */
    public function weekly($every = 1)
    {
        return $this->billEvery($every, BillingPeriod::WEEKLY);
    }

    /**
     * @param int $every
     * @return self
     */
    public function monthly($every = 1)
    {
        return $this->billEvery($every, BillingPeriod::MONTHLY);
    }

    /**
     * @param int $every
     * @return self
     */
    public function yearly($every = 1)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->billEvery($every, BillingPeriod::YEARLY);
    }

    /**
     * @param int $interval
     * @param string $period
     * @return $this
     */
    public function billEvery(int $interval, string $period)
    {
        if (!in_array($period, BillingPeriod::PERIOD)) {
            throw new Exception("Invalid period [{$interval}] in " . get_class($this));
        }
        $this->subscription->billing_interval = $interval;
        $this->subscription->billing_period = $period;
        return $this;
    }
}
