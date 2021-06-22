<?php

namespace ByTIC\Payments\Actions\Subscriptions\Charges;

use ByTIC\Payments\Models\Subscriptions\Subscription;
use ByTIC\Payments\Subscriptions\Billing\BillingPeriod;
use Nip\Utility\Date;

/**
 * Class CalculateNextCharge
 * @package ByTIC\Payments\Actions\Subscriptions\Charges
 */
class CalculateNextCharge
{
    /**
     * @param Subscription $subscription
     */
    public static function for($subscription)
    {
        $count = $subscription->charge_count > 0 ? $subscription->charge_count : 1;
        $subscription->charge_at = static::nextBillingDate(
            $subscription->start_at,
            $subscription->billing_period,
            $subscription->billing_interval * $count
        );
    }

    /**
     * @param \DateTime $startDate
     * @param $period
     * @param $interval
     */
    protected static function nextBillingDate(\DateTime $startDate, $period, $interval)
    {
        $startDate = Date::instance($startDate)->setHour(8)->setMinute(0);

        switch ($period) {
            case BillingPeriod::DAILY:
                return $startDate->addDays($interval);

            case BillingPeriod::WEEKLY:
                return $startDate->addWeeks($interval);

            case BillingPeriod::MONTHLY:
                return $startDate->addMonthsNoOverflow($interval);

            case BillingPeriod::YEARLY:
                return $startDate->addYears($interval);
        }
        throw new \InvalidArgumentException("Invalid period [{$period}] provided.");
    }
}
